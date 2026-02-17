-- Create Database
CREATE DATABASE IF NOT EXISTS lms_core;

USE lms_core;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    whatsapp_number VARCHAR(20) NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- Create Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- Insert a default admin into both tables (for backward compatibility and new structure)
-- Hash generated using password_hash('admin123', PASSWORD_BCRYPT)
INSERT IGNORE INTO
    users (
        name,
        email,
        whatsapp_number,
        username,
        password,
        role
    )
VALUES (
        'Super Admin',
        'admin@lmscore.com',
        '0123456789',
        'admin',
        '$2y$10$odgDoaI9huqX8jl75T0agO9ibGF523pHvJ.NdgoRRPfbn3HICXUaC',
        'admin'
    );

INSERT IGNORE INTO
    admins (
        name,
        email,
        username,
        password
    )
VALUES (
        'Super Admin',
        'admin@lmscore.com',
        'admin',
        '$2y$10$odgDoaI9huqX8jl75T0agO9ibGF523pHvJ.NdgoRRPfbn3HICXUaC'
    );

-- Create Courses Table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_title VARCHAR(150) NOT NULL,
    instructor VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    duration VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    video_zip VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- Create Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    payment_receipt VARCHAR(255) NOT NULL,
    status ENUM(
        'pending',
        'approved',
        'rejected'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Create Timetable Table
CREATE TABLE IF NOT EXISTS timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(150) NOT NULL,
    class_time VARCHAR(50) NOT NULL,
    class_description TEXT,
    day_name VARCHAR(20) NOT NULL,
    class_image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;