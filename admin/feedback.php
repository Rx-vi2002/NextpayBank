<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Get all feedback
$feedback_sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$feedback_result = $conn->query($feedback_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Review - NextPay Bank</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-panel" style="display: flex;">
        <div class="admin-sidebar" style="width: 250px;">
            <h3 style="padding: 0 2rem; margin-bottom: 2rem;">Admin Panel</h3>
            <a href="dashboard.php">Dashboard</a>
            <a href="feedback.php" style="background: #34495e;">Feedback Review</a>
            <a href="../logout.php">Logout</a>
        </div>

        <div class="admin-content" style="flex: 1;">
            <h1>Feedback Review</h1>
            <p>Review and manage user feedback submissions.</p>
            
            <div class="dashboard-card">
                <h3>User Feedback Submissions</h3>
                <p><strong>XSS Flag: FLAG{XSS_CR0SS_S1T3_SCR1PT1NG}</strong></p>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $feedback['id']; ?></td>
                            <td><?php echo $feedback['name']; ?></td>
                            <td><?php echo $feedback['email']; ?></td>
                            <td><?php echo $feedback['message']; // XSS Vulnerability ?></td>
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