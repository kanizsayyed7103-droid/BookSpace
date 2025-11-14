use bookspace;

DROP TABLE IF EXISTS password_resets;

CREATE TABLE password_resets (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used VARCHAR(3) NOT NULL,
    PRIMARY KEY (`id`)
)