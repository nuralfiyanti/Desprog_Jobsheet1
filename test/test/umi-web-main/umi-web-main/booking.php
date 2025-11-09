<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎬 Movie Ticketing</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .movie-card img {
      max-height: 250px;
      object-fit: cover;
    }
    .btn-sm:hover {
      transform: scale(1.05);
      transition: 0.2s;
    }
  </style>
</head>
<body class="bg-light">

  <!-- Navbar -->
  <header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">🎬 Movie Ticketing</h1>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a href="index.html" class="nav-link text-white">Home</a></li>
          <li class="nav-item"><a href="booking.php" class="nav-link active text-warning fw-bold">Book Tickets</a></li>
          <li class="nav-item"><a href="tickets.php" class="nav-link text-white">View All</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container mb-5">
    <!-- Alert -->
    <div id="alert-box"></div>

    <!-- Pilih Film -->
    <section class="booking my-4">
      <h2 class="mb-3">🎟 Choose a Movie</h2>
      <p class="text-muted">Select a movie to book tickets.</p>

      <div class="row" id="movie-list"></div>

      <!-- Form Booking -->
      <form id="booking-form" class="mt-4 card p-4 shadow-sm" hidden>
        <h5 id="selected-movie" class="mb-1 text-primary"></h5>
        <p id="selected-time" class="text-muted"></p>
        <div class="mb-3">
          <label for="seats" class="form-label">Number of Seats</label>
          <input type="number" id="seats" name="seats" class="form-control" min="1" max="10" value="1" required>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-warning fw-bold">🎫 Book Now</button>
        </div>
      </form>
    </section>

    <hr>

    <!-- Daftar Booking -->
    <section class="mt-5">
      <h3>📋 Booking List</h3>
      <table class="table table-bordered table-striped mt-3 align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Movie</th>
            <th>Seats</th>
            <th>Booked At</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody id="booking-table"></tbody>
      </table>
    </section>
  </main>

<script>
// =============================================================
// Konfigurasi & variabel dasar
// =============================================================
const movieList = document.getElementById('movie-list');
const bookingForm = document.getElementById('booking-form');
const bookingTable = document.getElementById('booking-table');
const selectedMovie = document.getElementById('selected-movie');
const selectedTime = document.getElementById('selected-time');
const alertBox = document.getElementById('alert-box');
let selectedMovieId = null;

// =============================================================
// Fungsi Alert Bootstrap
// =============================================================
function showAlert(message, type = "success") {
  alertBox.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
  setTimeout(() => (alertBox.innerHTML = ""), 3000);
}

// =============================================================
// Daftar Film (statis)
const movies = [
  { id: 1, title: "The Lost Kingdom", duration_minutes: 120, poster_url: "assets/movie1.jpg" },
  { id: 2, title: "Space Odyssey", duration_minutes: 135, poster_url: "assets/movie2.jpg" },
  { id: 3, title: "Love in Paris", duration_minutes: 110, poster_url: "assets/movie3.jpg" }
];

// =============================================================
// Menampilkan daftar film
function loadMovies() {
  movieList.innerHTML = movies.map(movie => `
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm movie-card movie-option" data-id="${movie.id}" data-title="${movie.title}">
        <img src="${movie.poster_url}" class="card-img-top img-fluid" alt="${movie.title}">
        <div class="card-body">
          <h5 class="card-title">${movie.title}</h5>
          <p class="card-text text-muted">Duration: ${movie.duration_minutes} min</p>
          <button class="btn btn-outline-warning w-100">Select</button>
        </div>
      </div>
    </div>
  `).join('');

  document.querySelectorAll('.movie-option button').forEach(btn => {
    btn.addEventListener('click', e => {
      const card = e.target.closest('.movie-option');
      selectedMovieId = card.dataset.id;
      selectedMovie.textContent = `Booking for: ${card.dataset.title}`;
      selectedTime.textContent = "Today at 7:30 PM";
      bookingForm.hidden = false;
    });
  });
}

// =============================================================
// Menampilkan daftar booking
async function loadBookings() {
  try {
    const res = await fetch('api.php?path=bookings');
    const data = await res.json();

    bookingTable.innerHTML = data.map(b => `
      <tr>
        <td>${b.id}</td>
        <td>${b.fullname}</td>
        <td>${b.title}</td>
        <td>${b.seats}</td>
        <td>${new Date(b.booked_at).toLocaleString()}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary me-2" onclick="editBooking(${b.id}, ${b.seats})">✏️ Update</button>
          <button class="btn btn-sm btn-danger" onclick="deleteBooking(${b.id})">🗑 Delete</button>
        </td>
      </tr>
    `).join('');
  } catch (err) {
    bookingTable.innerHTML = `<tr><td colspan="6" class="text-center text-muted">⚠️ Cannot load bookings.</td></tr>`;
  }
}

// =============================================================
// Delete Booking
async function deleteBooking(id) {
  if (!confirm("Are you sure you want to delete this booking?")) return;
  await fetch(`api.php?path=bookings/${id}`, { method: 'DELETE' });
  showAlert("Booking deleted successfully!", "danger");
  loadBookings();
}

// =============================================================
// Update Booking
async function editBooking(id, seats) {
  const newSeats = prompt("Enter new number of seats:", seats);
  if (!newSeats) return;

  const res = await fetch(`api.php?path=bookings/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ seats: Number(newSeats) })
  });

  const json = await res.json();
  showAlert(json.message, "primary");
  loadBookings();
}

// =============================================================
// Simpan Booking Baru
bookingForm.addEventListener('submit', async e => {
  e.preventDefault();
  if (!selectedMovieId) return alert("Please select a movie first!");

  const seats = document.getElementById('seats').value;
  const payload = { user_id: 2, movie_id: Number(selectedMovieId), seats: Number(seats) };

  const res = await fetch('api.php?path=bookings', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });

  const json = await res.json();
  showAlert(json.message, "success");
  bookingForm.hidden = true;
  loadBookings();
});

// =============================================================
// Jalankan awal
loadMovies();
loadBookings();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
