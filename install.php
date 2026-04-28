<?php
$conn = new mysqli("localhost", "root", "");

/* 1. CREATE DATABASE */
$conn->query("CREATE DATABASE IF NOT EXISTS hospital_db");
$conn->select_db("hospital_db");

/* 2. ADMINS TABLE */
$conn->query("CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

/* 3. USERS TABLE */
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(10),
    phone VARCHAR(20),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

/* 4. APPOINTMENTS TABLE (UPDATED) */
$conn->query("CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,

    doctor_name VARCHAR(100) NOT NULL,
    doctor_specialty VARCHAR(100) NOT NULL,

    department VARCHAR(100) NOT NULL,
    clinic_name VARCHAR(150) DEFAULT 'SwasthaSewa Hospital',

    problem_type VARCHAR(50) NOT NULL,
    problem_description TEXT,

    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(50) NOT NULL,
    appointment_type ENUM('Normal', 'Emergency') NOT NULL,

    status ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed') DEFAULT 'Pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Indexes for performance (important for crowd system)
    INDEX idx_date (appointment_date),
    INDEX idx_status (status),
    INDEX idx_department (department),
    INDEX idx_doctor (doctor_name),

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");
?>