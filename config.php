<?php
// Load environment variables
require_once 'load_env.php';
loadEnv(__DIR__ . '/.env');

// Get service URI from environment
$serviceUri = getenv('AIVEN_SERVICE_URI');

// Parse the service URI
$parts = parse_url($serviceUri);

$servername = $parts['host'];
$username = $parts['user'];
$password = $parts['pass'];
$port = $parts['port'];
$dbname = "defaultdb";

// Initialize mysqli and set SSL BEFORE connecting
$conn = mysqli_init();
if (!$conn) {
    die("mysqli_init failed");
}

// Set SSL options
$conn->ssl_set(NULL, NULL, __DIR__ . '/ca.pem', NULL, NULL);

// Now create the actual connection with SSL
if (!$conn->real_connect($servername, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if SSL is enabled
$result = $conn->query("SHOW STATUS LIKE 'Ssl_cipher'");
$row = $result->fetch_assoc();
if (!empty($row['Value'])) {
   // echo "SSL is enabled: " . $row['Value'] . "<br>\n";
} else {
    echo "SSL is NOT enabled<br>\n";
}

// Initialize database tables
function initializeDatabase($conn) {
    // Create users table
    $result = $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255),
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user'
    )");
    if ($result) {
        //echo "Users table created successfully<br>\n";
    }
    
    // Create invoices table
    $result = $conn->query("CREATE TABLE IF NOT EXISTS invoices (
        id INT PRIMARY KEY,
        user_id INT,
        amount DECIMAL(10,2),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    if ($result) {
       // echo "Invoices table created successfully<br>\n";
    }
    
    // Create admin_tokens table
    $result = $conn->query("CREATE TABLE IF NOT EXISTS admin_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        secret_token VARCHAR(255)
    )");
    if ($result) {
       // echo "Admin_tokens table created successfully<br>\n";
    }
    
    // Create feedback table
    $result = $conn->query("CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    if ($result) {
        //echo "Feedback table created successfully<br>\n";
    }
    
    // Insert sample data
    $result = $conn->query("INSERT IGNORE INTO users (username, password, role) VALUES 
        ('john_doe', 'user123', 'user'),
        ('admin', 'admin123', 'admin')
    ");
    if ($result) {
        //echo "Sample users inserted<br>\n";
    }
    
    $result = $conn->query("INSERT IGNORE INTO invoices (id, user_id, amount, description) VALUES 
        (1000, 1, 5000.00, 'Admin Invoice - FLAG{ID0R_1NS3CUR3_0BJ3CT_R3F3R3NC3}'),
        (1001, 2, 1500.00, 'Regular User Invoice')
    ");
    if ($result) {
       // echo "Sample invoices inserted<br>\n";
    }
    
    $result = $conn->query("INSERT IGNORE INTO admin_tokens (secret_token) VALUES 
        ('FLAG{SQL1_4DM1N_T0K3N_3XTR4CT10N}')
    ");
    if ($result) {
       // echo "Admin tokens inserted<br>\n";
    }
}

// Call the initialization function
initializeDatabase($conn);

//echo "<br>Database initialized successfully!<br>\n";

// Close connection
//$conn->close();
?>