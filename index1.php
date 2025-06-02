<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (isset($_SESSION['shopkeeper_id'])) {
    header('Location: pages/dashboard.php');
    exit();
} else {
    header('Location: pages/login.php');
    exit();
}
?>