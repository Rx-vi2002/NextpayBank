<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nextpay_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize database tables
function initializeDatabase($conn) {
    // Create users table
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255),
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user'
    )");
    
    // Create invoices table
    $conn->query("CREATE TABLE IF NOT EXISTS invoices (
        id INT PRIMARY KEY,
        user_id INT,
        amount DECIMAL(10,2),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create admin_tokens table
    $conn->query("CREATE TABLE IF NOT EXISTS admin_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        secret_token VARCHAR(255)
    )");
    
    // Create feedback table
    $conn->query("CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert sample data
    $conn->query("INSERT IGNORE INTO users (username, password, role) VALUES 
        ('john_doe', 'user123', 'user'),
        ('admin', 'admin123', 'admin')
    ");
    
    $conn->query("INSERT IGNORE INTO invoices (id, user_id, amount, description) VALUES 
        (1000, 1, 5000.00, 'Admin Invoice - FLAG{ID0R_1NS3CUR3_0BJ3CT_R3F3R3NC3}'),
        (1001, 2, 1500.00, 'Regular User Invoice')
    ");
    
    $conn->query("INSERT IGNORE INTO admin_tokens (secret_token) VALUES 
        ('FLAG{SQL1_4DM1N_T0K3N_3XTR4CT10N}')
    ");
}
?>