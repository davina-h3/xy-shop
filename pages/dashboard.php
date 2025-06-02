<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
checkAuth();

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_products FROM products");
$total_products = $stmt->fetch()['total_products'];

$stmt = $pdo->query("SELECT COALESCE(SUM(Quantity), 0) as total_stock_in FROM product_ins");
$total_stock_in = $stmt->fetch()['total_stock_in'];

$stmt = $pdo->query("SELECT COALESCE(SUM(Quantity), 0) as total_stock_out FROM product_outs");
$total_stock_out = $stmt->fetch()['total_stock_out'];

$current_stock = $total_stock_in - $total_stock_out;

include '../includes/header.php';
?>
<link rel="stylesheet" href="../css/style.css"><div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_products; ?></div>
        <div class="stat-label"><i class="fas fa-box"></i> Total Products</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_stock_in; ?></div>
        <div class="stat-label"><i class="fas fa-arrow-down"></i> Total Stock In</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_stock_out; ?></div>
        <div class="stat-label"><i class="fas fa-arrow-up"></i> Total Stock Out</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $current_stock; ?></div>
        <div class="stat-label"><i class="fas fa-warehouse"></i> Current Stock</div>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-chart-line"></i> Recent Activities</h3>
    <?php
    $stmt = $pdo->query("
        (SELECT 'IN' as type, p.ProductName, pi.Quantity, pi.DateTime 
         FROM product_ins pi 
         JOIN products p ON pi.ProductCode = p.ProductCode 
         ORDER BY pi.DateTime DESC LIMIT 5)
        UNION ALL
        (SELECT 'OUT' as type, p.ProductName, po.Quantity, po.DateTime 
         FROM product_outs po 
         JOIN products p ON po.ProductCode = p.ProductCode 
         ORDER BY po.DateTime DESC LIMIT 5)
        ORDER BY DateTime DESC LIMIT 10
    ");
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Date/Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch()): ?>
            <tr>
                <td>
                    <span class="badge <?php echo $row['type'] == 'IN' ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $row['type']; ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
                <td><?php echo $row['Quantity']; ?></td>
                <td><?php echo date('M d, Y H:i', strtotime($row['DateTime'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>