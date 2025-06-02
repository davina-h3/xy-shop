<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY Shop - Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php if (isset($_SESSION['shopkeeper_id'])): ?>
    <nav class="navbar">
        <div class="nav-brand">
            <h2><i class="fas fa-store"></i> XY Shop</h2>
        </div>
        <ul class="nav-menu">
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="stock_in.php"><i class="fas fa-arrow-down"></i> Stock In</a></li>
            <li><a href="stock_out.php"><i class="fas fa-arrow-up"></i> Stock Out</a></li>
            <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
    </nav>
    <?php endif; ?>
    <main class="main-content">