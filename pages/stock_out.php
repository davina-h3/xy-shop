<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
checkAuth();

$message = '';
$error = '';

// Handle form submission
if ($_POST && isset($_POST['action']) && $_POST['action'] == 'add_stock_out') {
    $productCode = $_POST['productCode'];
    $quantity = (int)$_POST['quantity'];
    $unitPrice = (float)$_POST['unitPrice'];
    $dateTime = $_POST['dateTime'];
    
    if (empty($productCode) || $quantity <= 0 || $unitPrice <= 0 || empty($dateTime)) {
        $error = 'All fields are required and must have valid values';
    } else {
        // Check available stock
        $stmt = $pdo->prepare("
            SELECT 
                COALESCE(SUM(pi.Quantity), 0) - COALESCE(SUM(po.Quantity), 0) as available_stock
            FROM products p
            LEFT JOIN product_ins pi ON p.ProductCode = pi.ProductCode
            LEFT JOIN product_outs po ON p.ProductCode = po.ProductCode
            WHERE p.ProductCode = ?
        ");
        $stmt->execute([$productCode]);
        $availableStock = $stmt->fetch()['available_stock'];
        
        if ($quantity > $availableStock) {
            $error = "Insufficient stock. Available: $availableStock";
        } else {
            $totalPrice = $quantity * $unitPrice;
            
            try {
                $stmt = $pdo->prepare("INSERT INTO product_outs (ProductCode, DateTime, Quantity, UnitPrice, TotalPrice) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$productCode, $dateTime, $quantity, $unitPrice, $totalPrice]);
                $message = 'Stock out record added successfully!';
            } catch (PDOException $e) {
                $error = 'Failed to add stock out record';
            }
        }
    }
}

// Get products with available stock
$stmt = $pdo->query("
    SELECT 
        p.ProductCode, 
        p.ProductName,
        COALESCE(SUM(pi.Quantity), 0) - COALESCE(SUM(po.Quantity), 0) as available_stock
    FROM products p
    LEFT JOIN product_ins pi ON p.ProductCode = pi.ProductCode
    LEFT JOIN product_outs po ON p.ProductCode = po.ProductCode
    GROUP BY p.ProductCode, p.ProductName
    HAVING available_stock > 0
    ORDER BY p.ProductName
");
$products = $stmt->fetchAll();

// Get recent stock out records
$stmt = $pdo->query("
    SELECT po.*, p.ProductName 
    FROM product_outs po 
    JOIN products p ON po.ProductCode = p.ProductCode 
    ORDER BY po.DateTime DESC 
    LIMIT 20
");
$stockOutRecords = $stmt->fetchAll();

include '../includes/header.php';
?>
<link rel="stylesheet" href="../css/style.css">
<div class="card">
    <h3><i class="fas fa-arrow-up"></i> Stock Out Management</h3>
    
    <?php if ($message): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="stock-form">
        <input type="hidden" name="action" value="add_stock_out">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
                <label for="productCode">Product</label>
                <select id="productCode" name="productCode" required onchange="updateAvailableStock()">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['ProductCode']; ?>" data-stock="<?php echo $product['available_stock']; ?>">
                            <?php echo htmlspecialchars($product['ProductCode'] . ' - ' . $product['ProductName'] . ' (Stock: ' . $product['available_stock'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
                <small id="stockInfo"></small>
            </div>
            
            <div class="form-group">
                <label for="unitPrice">Unit Price</label>
                <input type="number" id="unitPrice" name="unitPrice" step="0.01" min="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="dateTime">Date & Time</label>
                <input type="datetime-local" id="dateTime" name="dateTime" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="totalPrice">Total Price</label>
            <input type="number" id="totalPrice" step="0.01" readonly style="background: #f8f9fa;">
        </div>
        
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-minus"></i> Add Stock Out
        </button>
    </form>
</div>

<div class="card">
    <h3><i class="fas fa-history"></i> Recent Stock Out Records</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Date & Time</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stockOutRecords as $record): ?>
            <tr>
                <td><?php echo htmlspecialchars($record['ProductName']); ?></td>
                <td><?php echo date('M d, Y H:i', strtotime($record['DateTime'])); ?></td>
                <td><?php echo $record['Quantity']; ?></td>
                <td>$<?php echo number_format($record['UnitPrice'], 2); ?></td>
                <td>$<?php echo number_format($record['TotalPrice'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Set current date/time as default
document.getElementById('dateTime').value = new Date().toISOString().slice(0, 16);

// Calculate total price automatically
document.getElementById('quantity').addEventListener('input', calculateTotal);
document.getElementById('unitPrice').addEventListener('input', calculateTotal);

function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const unitPrice = parseFloat(document.getElementById('unitPrice').value) || 0;
    const totalPrice = quantity * unitPrice;
    document.getElementById('totalPrice').value = totalPrice.toFixed(2);
}

function updateAvailableStock() {
    const select = document.getElementById('productCode');
    const selectedOption = select.options[select.selectedIndex];
    const quantityInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stockInfo');
    
    if (selectedOption.dataset.stock) {
        const availableStock = parseInt(selectedOption.dataset.stock);
        stockInfo.textContent = `Available stock: ${availableStock}`;
        quantityInput.max = availableStock;
    } else {
        stockInfo.textContent = '';
        quantityInput.removeAttribute('max');
    }# XY Shop PHP Inventory Management System

## Project Structure