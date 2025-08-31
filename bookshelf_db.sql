CREATE DATABASE IF NOT EXISTS bookspace;

USE bookspace;

CREATE TABLE IF NOT EXISTS bookshelf (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  rating DECIMAL(2,1) DEFAULT NULL,
  cover VARCHAR(500) DEFAULT NULL
);

INSERT INTO bookshelf (title, author, rating, cover) VALUES
('The Kite Runner','Khaled Hosseini',4.8,'https://covers.openlibrary.org/b/id/8228691-L.jpg'),
('Inferno','Dan Brown',4.2,'https://covers.openlibrary.org/b/id/10594740-L.jpg');
