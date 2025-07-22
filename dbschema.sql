CREATE DATABASE class_attendance;

USE class_attendance;

CREATE TABLE attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    class VARCHAR(50) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    status VARCHAR(20) NOT NULL,
    remarks VARCHAR(255),
    teacher_name VARCHAR(100) NOT NULL,
    period VARCHAR(20) NOT NULL,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);