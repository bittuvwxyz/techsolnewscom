CREATE DATABASE IF NOT EXISTS website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE website;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verified TINYINT(1) NOT NULL DEFAULT 0,
    verification_token VARCHAR(255) DEFAULT NULL,
    reset_token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blog (
    blog_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blog_title VARCHAR(255) NOT NULL,
    blog_short_description TEXT DEFAULT NULL,
    blog_contents LONGTEXT DEFAULT NULL,
    blog_category VARCHAR(100) DEFAULT NULL,
    blog_author VARCHAR(100) DEFAULT NULL,
    blog_hits INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO blog (
    blog_title,
    blog_short_description,
    blog_contents,
    blog_category,
    blog_author
)
VALUES
(
    'Welcome to TechSolNews',
    'A modern news platform built with PHP and MySQL.',
    'This is a starter post for your blog section. You can update or replace it from the database.',
    'General',
    'Admin'
)
ON DUPLICATE KEY UPDATE
blog_title = VALUES(blog_title);