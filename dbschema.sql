CREATE DATABASE IF NOT EXISTS hotel_registration;

USE hotel_registration;

DROP TABLE IF EXISTS hotel_registrations;
CREATE TABLE hotel_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    num_guests INT NOT NULL,
    special_requests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);