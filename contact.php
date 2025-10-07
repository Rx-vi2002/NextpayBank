<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // XSS Vulnerability - Storing unsanitized input
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if ($stmt->execute()) {
        $success = 'Thank you for your feedback! Our admin will review it shortly.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - NextPay Bank</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>🏦 NextPay Bank</h2>
            </div>
            <div class="nav-menu">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="invoices.php" class="nav-link">Invoices</a>
                <a href="contact.php" class="nav-link active">Contact</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Contact Support</h2>
            <p>We'd love to hear from you! Please fill out the form below.</p>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Feedback Message:</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Tell us about your experience..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Feedback</button>
            </form>
            
            <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                <h4>XSS Challenge:</h4>
                <p>Try submitting: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></p>
                <p>The admin will see your feedback and the script will execute!</p>
            </div>
        </div>
    </div>
</body>
</html>