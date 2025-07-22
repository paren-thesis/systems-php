CREATE DATABASE IF NOT EXISTS bus_ticket_booking;

USE bus_ticket_booking;

DROP TABLE IF EXISTS bus_tickets;
CREATE TABLE bus_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    travel_date DATE NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    departure_location VARCHAR(100) NOT NULL,
    destination_location VARCHAR(100) NOT NULL,
    number_of_tickets INT NOT NULL,
    departure_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);