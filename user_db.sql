CREATE DATABASE IF NOT EXISTS bookspace;
USE bookspace;
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('reader', 'author', 'admin') NOT NULL DEFAULT 'reader',
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

<<<<<<< HEAD
   ALTER TABLE users 
ADD profile_image VARCHAR(255) ;
=======
    ALTER TABLE users
ADD COLUMN profile_image VARCHAR(255) NULL DEFAULT NULL;
>>>>>>> 9780395e9e361dbdc6a06f21cd28764e5af97aac
