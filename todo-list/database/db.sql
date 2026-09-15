CREATE DATABASE IF NOT EXISTS todolist
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE todolist;

CREATE TABLE IF NOT EXISTS task(
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255),
    status VARCHAR(128) DEFAULT('Pending'),
    position INT NOT NULL DEFAULT 0
);