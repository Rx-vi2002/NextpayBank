<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NextPay Bank</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>🏦 NextPay Bank</h2>
            </div>
            <div class="nav-menu">
                <a href="dashboard.php" class="nav-link active">Dashboard</a>
                <a href="invoices.php" class="nav-link">Invoices</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <?php if ($role === 'admin'): ?>
                    <a href="admin/dashboard.php" class="nav-link">Admin Panel</a>
                <?php endif; ?>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Your banking dashboard</p>
        </div>

        <div class="nav-menu-dashboard">
            <a href="invoices.php">View Invoices</a>
            <a href="contact.php">Contact Support</a>
            <?php if ($role === 'admin'): ?>
                <a href="admin/dashboard.php">Admin Panel</a>
            <?php endif; ?>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>💰 Checking Account</h3>
                <p>Balance: $5,250.00</p>
            </div>
            <div class="dashboard-card">
                <h3>🏦 Savings Account</h3>
                <p>Balance: $12,500.00</p>
            </div>
            <div class="dashboard-card">
                <h3>💳 Credit Card</h3>
                <p>Balance: $1,250.00</p>
            </div>
            <div class="dashboard-card">
                <h3>📈 Investments</h3>
                <p>Value: $45,000.00</p>
            </div>
        </div>

        <div class="dashboard-card">
            <h3>Recent Transactions</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15</td>
                        <td>Grocery Store</td>
                        <td>-$85.50</td>
                        <td>Completed</td>
                    </tr>
                    <tr>
                        <td>2024-01-14</td>
                        <td>Salary Deposit</td>
                        <td>+$3,500.00</td>
                        <td>Completed</td>
                    </tr>
                    <tr>
                        <td>2024-01-12</td>
                        <td>Online Shopping</td>
                        <td>-$120.75</td>
                        <td>Completed</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>