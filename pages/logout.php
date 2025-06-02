<?php
require_once '../includes/auth.php';

// Call the logout function
logout();

// Redirect to the login page inside the "pages" folder
header('Location: pages/login.php');
exit();
?>
