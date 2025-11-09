-- init_sql.sql
-- Buat tabel film dan seed sample data
CREATE TABLE IF NOT EXISTS film (
  id SERIAL PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  genre VARCHAR(80) NOT NULL,
  tahun INT,
  durasi INT
);

-- Beberapa data contoh
INSERT INTO film (judul, genre, tahun, durasi) VALUES
('The Matrix', 'Sci-Fi', 1999, 136),
('Inception', 'Sci-Fi/Thriller', 2010, 148),
('Interstellar', 'Sci-Fi', 2014, 169);
