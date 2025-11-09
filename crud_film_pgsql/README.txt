CRUD Film - PHP + PostgreSQL (prepared for your environment)

Files included:
- koneksi.php      : koneksi ke PostgreSQL (sesuaikan jika perlu)
- index.php        : daftar film (Read)
- tambah.php       : tambah film (Create)
- edit.php         : edit film (Update)
- hapus.php        : hapus film (Delete)
- init_sql.sql     : script SQL untuk membuat database & tabel
- README.txt       : (this file)

How to use (local machine):
1. Buat database di PostgreSQL (pgAdmin) dengan nama 'crud_film' atau ganti nama di koneksi.php.
   - Open pgAdmin / psql and run: CREATE DATABASE crud_film;
2. Import/execute file init_sql.sql (it contains CREATE TABLE and sample data).
   - Or run the commands manually:
     CREATE TABLE film (
        id SERIAL PRIMARY KEY,
        judul VARCHAR(150),
        genre VARCHAR(80),
        tahun INT,
        durasi INT
     );
3. Sesuaikan koneksi di koneksi.php jika username/password/host/port berbeda.
   (Default di file: user=postgres, password=12345678, port=5432)
4. Jalankan PHP built-in server di folder ini:
   php -S localhost:8080
5. Buka http://localhost:8080/index.php

Notes:
- Kode sudah menggunakan parameterized queries (pg_query_params / pg_prepare) untuk mengurangi risiko SQL injection.
- Jika ingin menggunakan database yang sudah ada (movie_db), kamu bisa:
  - Rename koneksi.php -> ganti $dbname ke 'movie_db'.
  - Pastikan tidak ada konflik nama tabel.
