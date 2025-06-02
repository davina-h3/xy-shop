<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (isset($_SESSION['shopkeeper_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if ($_POST) {
    if (login($_POST['username'], $_POST['password'], $pdo)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - XY Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST">
            <h2><i class="fas fa-store"></i> XY Shop Login</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
            
            <div style="text-align: center;">
                <p>Don't have an account? <a href="signup.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>