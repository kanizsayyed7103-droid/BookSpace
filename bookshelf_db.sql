CREATE DATABASE IF NOT EXISTS bookspace;

USE bookspace;

CREATE TABLE bookshelf (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    rating FLOAT NOT NULL,
    cover VARCHAR(500) NOT NULL
<<<<<<< HEAD
);

INSERT INTO bookshelf (title, author, rating, cover) VALUES
('The Kite Runner','Khaled Hosseini',4.8,'https://covers.openlibrary.org/b/id/8228691-L.jpg'),
('Inferno','Dan Brown',4.2,'https://covers.openlibrary.org/b/id/10594740-L.jpg');
=======
);
>>>>>>> 73c9072f0ffac4feb61502c5402784c4fc5428b1
