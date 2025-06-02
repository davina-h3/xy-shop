<?php
session_start();

function checkAuth() {
    if (!isset($_SESSION['shopkeeper_id'])) {
        header('Location: login.php');
        exit();
    }
}

function login($username, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM shopkeepers WHERE UserName = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['shopkeeper_id'] = $user['ShopkeeperId'];
        $_SESSION['username'] = $user['UserName'];
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>