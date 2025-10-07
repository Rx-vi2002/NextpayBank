<?php
session_start();
require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // SQL Injection Vulnerability - Direct string concatenation
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'admin'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'];
        
        // Get admin token (SQL Injection flag)
        $token_sql = "SELECT * FROM admin_tokens LIMIT 1";
        $token_result = $conn->query($token_sql);
        if ($token_result->num_rows > 0) {
            $token = $token_result->fetch_assoc();
            $_SESSION['admin_token'] = $token['secret_token'];
        }
        
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid admin credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NextPay Bank</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>🏦 NextPay Bank - Admin</h2>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login as Admin</button>
        </form>
        
        <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
            <h4>SQL Injection Challenge:</h4>
            <p>Try: <code>admin' OR '1'='1'--</code> in username field</p>
            <p>Leave password empty or enter anything</p>
        </div>
    </div>
</body>
</html>