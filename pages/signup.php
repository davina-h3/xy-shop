<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (isset($_SESSION['shopkeeper_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters long';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM shopkeepers WHERE UserName = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetchColumn() > 0) {
            $error = 'Username already exists';
        } else {
            // Create new user
            try {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO shopkeepers (UserName, Password) VALUES (?, ?)");
                $stmt->execute([$username, $hashed_password]);
                
                $success = 'Account created successfully! You can now login.';
            } catch (PDOException $e) {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - XY Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST">
            <h2><i class="fas fa-user-plus"></i> Create Account</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                <small>At least 3 characters</small>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
                <small>At least 6 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                <i class="fas fa-user-plus"></i> Sign Up
            </button>
            
            <div style="text-align: center;">
                <p>Already have an account? <a href="login.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>