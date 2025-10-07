<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Read XSS flag
$xss_flag = file_exists('flag.txt') ? file_get_contents('flag.txt') : 'FLAG{XSS_CR0SS_S1T3_SCR1PT1NG}';

// Get feedback for XSS vulnerability
$feedback_sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$feedback_result = $conn->query($feedback_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NextPay Bank</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-panel" style="display: flex;">
        <div class="admin-sidebar" style="width: 250px;">
            <h3 style="padding: 0 2rem; margin-bottom: 2rem;">Admin Panel</h3>
            <a href="dashboard.php">Dashboard</a>
            <a href="feedback.php">Feedback Review</a>
            <a href="../logout.php">Logout</a>
        </div>

        <div class="admin-content" style="flex: 1;">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            
            <?php if (isset($_SESSION['admin_token'])): ?>
                <div class="dashboard-card" style="background: #d4edda; border: 1px solid #c3e6cb;">
                    <h3>🔑 Admin Security Token</h3>
                    <p><strong>Flag: <?php echo $_SESSION['admin_token']; ?></strong></p>
                    <p>This token was extracted via SQL Injection!</p>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>👥 Total Users</h3>
                    <p>1,254</p>
                </div>
                <div class="dashboard-card">
                    <h3>💳 Transactions Today</h3>
                    <p>342</p>
                </div>
                <div class="dashboard-card">
                    <h3>⚠️ Alerts</h3>
                    <p>12</p>
                </div>
                <div class="dashboard-card">
                    <h3>📝 Pending Reviews</h3>
                    <p><?php echo $feedback_result->num_rows; ?></p>
                </div>
            </div>

            <div class="dashboard-card">
                <h3>Recent Feedback</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $feedback['name']; ?></td>
                            <td><?php echo $feedback['email']; ?></td>
                            <td><?php echo $feedback['message']; // XSS Vulnerability - unsanitized output ?></td>
                            <td><?php echo $feedback['created_at']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>