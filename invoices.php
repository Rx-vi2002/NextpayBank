<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// IDOR Vulnerability - No access control check
$invoice_id = isset($_GET['id']) ? $_GET['id'] : 1001;

// Direct file reading without authorization check
$invoice_file = "invoices/invoice_$invoice_id.txt";
$invoice_content = "Invoice not found or access denied.";

if (file_exists($invoice_file)) {
    $invoice_content = file_get_contents($invoice_file);
} else {
    // Fallback to database
    $sql = "SELECT * FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
        $invoice_content = "Invoice #{$invoice['id']}\nAmount: \${$invoice['amount']}\nDescription: {$invoice['description']}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - NextPay Bank</title>
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
                <a href="invoices.php" class="nav-link active">Invoices</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="invoice-container">
            <div class="invoice-header">
                <h1>Invoice Details</h1>
                <p>Invoice ID: <?php echo $invoice_id; ?></p>
            </div>
            
            <div class="invoice-details">
                <pre><?php echo htmlspecialchars($invoice_content); ?></pre>
            </div>
            
            <div class="nav-menu-dashboard">
                <a href="invoices.php?id=1001">View Invoice 1001</a>
                <a href="invoices.php?id=1002">View Invoice 1002</a>
                <a href="invoices.php?id=1000">View Invoice 1000</a>
            </div>
        </div>
    </div>
</body>
</html>