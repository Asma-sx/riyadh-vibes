-- Riyadh Vibes: database setup
-- Import this file into an EMPTY database (phpMyAdmin > Import).
-- On localhost you can first run:  CREATE DATABASE login; USE login;

CREATE TABLE IF NOT EXISTS log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL  -- stores a password_hash(), never the plain password
);

CREATE TABLE IF NOT EXISTS catagory (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,   -- event name
  price VARCHAR(150) NOT NULL,  -- event place
  image VARCHAR(255) NOT NULL
);

INSERT INTO log (username, password) VALUES
  ('admin', '$2y$10$6e6YdfyPUQV0UD8SlMn1E.0Y.u.3Yg4.r5Yl8TZMK1ghs./aglTMm');

INSERT INTO catagory (name, price, image) VALUES
  ('Boulevard World', 'Boulevard World', 'IMG-20241005-WA0002.jpg'),
  ('Boulevard City', 'Boulevard City', 'IMG-20241005-WA0005.jpg'),
  ('Riyadh Zoo', 'Riyadh Zoo', 'IMG-20241005-WA0006.jpg'),
  ('Riyadh Season Opening', 'Riyadh', 'photo_2024-10-04_23-09-57.jpg');
