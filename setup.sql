-- Simple Todo List Database Setup
-- Run this in your MySQL database

CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

-- Create category table
CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create todo table
CREATE TABLE IF NOT EXISTS todo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE
);

-- Insert sample categories
INSERT INTO category (name) VALUES 
('Category A'),
('Category B'),
('Category C');

