// Minimal static server + API using only built-in Node modules and postgres.js
const http = require('http'); // baawa node.js 
const fs = require('fs'); // file statis
const path = require('path'); // manipulasi path file
const crypto = require('crypto'); // hash password dan salt
  
const postgres = require('postgres'); 
const sql = postgres(process.env.DATABASE_URL || 'postgres://postgres:12345678@localhost:5432/moviedb'); 

// Gunakan PORT dari environment variable atau default ke 3000
const PORT = process.env.PORT ? Number(process.env.PORT) : 3000;

// Membuat tabel users jika belum ada
async function ensureSchema() {
  await sql`CREATE TABLE IF NOT EXISTS users (
    id serial PRIMARY KEY,
    fullname text,
    email text UNIQUE,
    password_hash text,
    salt text
  )`;

  await sql`CREATE TABLE IF NOT EXISTS movies (
      id serial PRIMARY KEY,
      title text NOT NULL,
      duration_minutes integer,
      poster_url text
  )`;
    
  await sql`CREATE TABLE IF NOT EXISTS bookings (
      id serial PRIMARY KEY,
      user_id integer REFERENCES users(id) ON DELETE CASCADE,
      movie_id integer REFERENCES movies(id) ON DELETE RESTRICT,
      seats integer NOT NULL,
      booked_at timestamp WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
  )`;
    
  const movieCount = await sql`SELECT count(*) FROM movies`;
  if (movieCount[0].count === '0') {
      console.log('Inserting sample movies...');
      await sql`
          INSERT INTO movies (id, title, duration_minutes, poster_url) VALUES 
          (1, 'Midnight City', 120, 'assets/movie1.jpg'),
          (2, 'Ocean Quest', 150, 'assets/movie2.jpg'),
          (3, 'Sky High', 90, 'assets/movie3.jpg')
          ON CONFLICT (id) DO NOTHING
      `;
  }
}

//melayani file statis
function serveStatic(req, res, filePath) {
  const ext = path.extname(filePath).toLowerCase();
  const map = {
    '.html': 'text/html',
    '.css': 'text/css',
    '.js': 'application/javascript',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.svg': 'image/svg+xml',
    '.json': 'application/json'
  };
  fs.readFile(filePath, (err, data) => {
    if (err) {
      res.writeHead(404, {'Content-Type': 'text/plain'});
      res.end('Not found');
      return;
    }
    res.writeHead(200, {'Content-Type': map[ext] || 'application/octet-stream'});
    res.end(data);
  });
}

//parsing request bod
function parseBody(req) {
  return new Promise((resolve, reject) => {
    let body = '';
    req.on('data', chunk => body += chunk);
    req.on('end', () => {
      try {
        const obj = JSON.parse(body || '{}');
        resolve(obj);
      } catch (e) {
        resolve({});
      }
    });
    req.on('error', reject);
  });
}

//hash password
function hashPassword(password, salt) {
  const hash = crypto.pbkdf2Sync(password, salt, 310000, 32, 'sha256');
  return hash.toString('hex');
}

// Membuat server HTTP
const server = http.createServer(async (req, res) => {
  const url = new URL(req.url, `http://${req.headers.host}`);
  try {
    //API: /api/register
    if (url.pathname === '/api/register' && req.method === 'POST') {
      const body = await parseBody(req);
      const { fullname, email, password } = body;
      if (!email || !password) {
        res.writeHead(400, {'Content-Type':'application/json'});
        res.end(JSON.stringify({ ok: false, message: 'Email and password required' }));
        return;
      }
      // check exists
      const existing = await sql`SELECT id FROM users WHERE email=${email}`;
      if (existing.length) {
        res.writeHead(409, {'Content-Type':'application/json'});
        res.end(JSON.stringify({ ok: false, message: 'Email already registered' }));
        return;
      }
      const salt = crypto.randomBytes(16).toString('hex');
      const password_hash = hashPassword(password, salt);
      await sql`INSERT INTO users (fullname, email, password_hash, salt) VALUES (${fullname}, ${email}, ${password_hash}, ${salt})`;
      res.writeHead(201, {'Content-Type':'application/json'});
      res.end(JSON.stringify({ ok: true, message: 'Registered' }));
      return;
    }

   // AAPI: /api/login
    if (url.pathname === '/api/login' && req.method === 'POST') {
      const body = await parseBody(req);
      const { email, password } = body;
      if (!email || !password) {
        res.writeHead(400, {'Content-Type':'application/json'});
        res.end(JSON.stringify({ ok: false, message: 'Email and password required' }));
        return;
      }
      //Cari user di database
      const rows = await sql`SELECT id, fullname, email, password_hash, salt FROM users WHERE email=${email} LIMIT 1`;
      if (!rows || !rows.length) {
        res.writeHead(401, {'Content-Type':'application/json'});
        res.end(JSON.stringify({ ok: false, message: 'Invalid credentials' }));
        return;
      }
      // Verifikasi password
      const user = rows[0];
      const computed = hashPassword(password, user.salt);
      if (computed !== user.password_hash) {
        res.writeHead(401, {'Content-Type':'application/json'});
        res.end(JSON.stringify({ ok: false, message: 'Invalid credentials' }));
        return;
      }
      //email dan password cocok
      res.writeHead(200, {'Content-Type':'application/json'});
      res.end(JSON.stringify({ ok: true, message: 'Logged in', user: { id: user.id, fullname: user.fullname, email: user.email } }));
      return;
    }

   // Users list 
   if (url.pathname === '/api/users' && req.method === 'GET') {
    const users = await sql`SELECT id, fullname, email FROM users ORDER BY id`;
    res.writeHead(200, { 'Content-Type': 'application/json' }); 
    return res.end(JSON.stringify(users));
    }

    // --- Movies list ---
    if (url.pathname === '/api/movies' && req.method === 'GET') { 
    const movies = await sql`SELECT * FROM movies ORDER BY id`; 
    res.writeHead(200, { 'Content-Type': 'application/json' }); 
    return res.end(JSON.stringify(movies)); 
  }

  // --- Bookings ---
  if (url.pathname === '/api/bookings' && req.method === 'POST') { 
    const { user_id, movie_id, seats } = await parseBody(req); 
    if (!user_id || !movie_id || !seats) { 
      res.writeHead(400, { 'Content-Type': 'application/json' }); 
      return res.end(JSON.stringify({ ok: false, message: 'Missing data' })); } await sql`INSERT INTO bookings (user_id, movie_id, seats) VALUES (${user_id}, ${movie_id}, ${seats})`; res.writeHead(201, { 'Content-Type': 'application/json' }); return res.end(JSON.stringify({ ok: true, message: 'Booking successful' })); 
  }

  if (url.pathname === '/api/bookings' && req.method === 'GET') { 
    const rows = await sql` SELECT b.id, u.fullname, m.title, b.seats, b.booked_at FROM bookings b JOIN users u ON b.user_id = u.id JOIN movies m ON b.movie_id = m.id ORDER BY b.booked_at DESC `; res.writeHead(200, { 'Content-Type': 'application/json' }); return res.end(JSON.stringify(rows)); }
  // Melayani file statis
    let filePath = url.pathname === '/' ? '/index.html' : url.pathname;
    filePath = path.join(__dirname, filePath);
    // c path traversal
    if (!filePath.startsWith(__dirname)) {
      res.writeHead(403);
      res.end('Forbidden');
      return;
    }

    //c path apa ada di disk
    if (fs.existsSync(filePath) && fs.statSync(filePath).isFile()) {
      serveStatic(req, res, filePath);
      return;
    }
    // k bukan try index.html in folder
    if (fs.existsSync(filePath + '/index.html')) {
      serveStatic(req, res, filePath + '/index.html');
      return;
    }

    // file tidak ada sama sekali → kirim 404
    res.writeHead(404, {'Content-Type':'text/plain'});
    res.end('Not found');
    //error server (try...catch)
  } catch (err) {
    console.error(err);
    res.writeHead(500, {'Content-Type':'application/json'});
    res.end(JSON.stringify({ ok:false, message: 'Server error' }));
  }
});

//Menjalankan server
ensureSchema().then(() => {
  server.listen(PORT, () => console.log(`Server listening on http://localhost:${PORT}`));
}).catch(err => {
  console.error('Failed to set up DB schema', err);
  process.exit(1);
});
