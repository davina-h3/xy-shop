<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
checkAuth();

$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $productCode = trim($_POST['productCode']);
                $productName = trim($_POST['productName']);
                $productPrice = trim($_POST['productPrice']); // New price field
                
                // Validate price is numeric
                if (!is_numeric($productPrice)) {
                    $error = 'Price must be a valid number';
                    break;
                }
                
                if (empty($productCode) || empty($productName) || empty($productPrice)) {
                    $error = 'All fields are required';
                } else {
                    try {
                        // Add price to SQL query
                        $stmt = $pdo->prepare("INSERT INTO products (ProductCode, ProductName, Price) VALUES (?, ?, ?)");
                        $stmt->execute([$productCode, $productName, $productPrice]);
                        $message = 'Product added successfully!';
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) {
                            $error = 'Product code already exists';
                        } else {
                            $error = 'Failed to add product: ' . $e->getMessage();
                        }
                    }
                }
                break;
                
            case 'update':
                $productCode = $_POST['productCode'];
                $productName = trim($_POST['productName']);
                $productPrice = trim($_POST['productPrice']); // New price field
                
                // Validate price is numeric
                if (!is_numeric($productPrice)) {
                    $error = 'Price must be a valid number';
                    break;
                }
                
                if (empty($productName) || empty($productPrice)) {
                    $error = 'Product name and price are required';
                } else {
                    try {
                        // Add price to update query
                        $stmt = $pdo->prepare("UPDATE products SET ProductName = ?, Price = ? WHERE ProductCode = ?");
                        $stmt->execute([$productName, $productPrice, $productCode]);
                        $message = 'Product updated successfully!';
                    } catch (PDOException $e) {
                        $error = 'Failed to update product: ' . $e->getMessage();
                    }
                }
                break;
                
            case 'delete':
                $productCode = $_POST['productCode'];
                try {
                    $stmt = $pdo->prepare("DELETE FROM products WHERE ProductCode = ?");
                    $stmt->execute([$productCode]);
                    $message = 'Product deleted successfully!';
                } catch (PDOException $e) {
                    $error = 'Cannot delete product. It may have associated stock records.';
                }
                break;
        }
    }
}

// Get all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY ProductName");
$products = $stmt->fetchAll();

include '../includes/header.php';
?>
<link rel="stylesheet" href="../css/style.css">
<div class="card">
    <h3><i class="fas fa-box"></i> Product Management</h3>
    
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
    
    <button class="btn btn-primary" onclick="openModal('addModal')">
        <i class="fas fa-plus"></i> Add New Product
    </button>
    
    <table class="table">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Price</th> <!-- New price column -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['ProductCode']); ?></td>
                <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                <td><?php echo '$' . number_format($product['Price'], 2); ?></td> <!-- Formatted price -->
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editProduct('<?php echo $product['ProductCode']; ?>', '<?php echo htmlspecialchars($product['ProductName']); ?>', '<?php echo $product['Price']; ?>')">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct('<?php echo $product['ProductCode']; ?>')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="productCode">Product Code</label>
                <input type="text" id="productCode" name="productCode" required>
            </div>
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="productPrice">Price ($)</label>
                <input type="number" id="productPrice" name="productPrice" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h3>Edit Product</h3>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" id="editProductCode" name="productCode">
            <div class="form-group">
                <label for="editProductName">Product Name</label>
                <input type="text" id="editProductName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="editProductPrice">Price ($)</label>
                <input type="number" id="editProductPrice" name="productPrice" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this product?</p>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" id="deleteProductCode" name="productCode">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
        </form>
    </div>
</div>

<script>
function editProduct(code, name, price) {
    document.getElementById('editProductCode').value = code;
    document.getElementById('editProductName').value = name;
    document.getElementById('editProductPrice').value = price;
    openModal('editModal');
}

function deleteProduct(code) {
    document.getElementById('deleteProductCode').value = code;
    openModal('deleteModal');
}

function openModal(id) {
    document.getElementById(id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>

<?php include '../includes/footer.php'; ?>