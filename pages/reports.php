<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
checkAuth();

// Get product stock data
$stmt = $pdo->query("
    SELECT 
        p.ProductCode,
        p.ProductName,
        p.Price,
        COALESCE(SUM(pi.Quantity), 0) AS TotalIn,
        COALESCE(SUM(po.Quantity), 0) AS TotalOut,
        (COALESCE(SUM(pi.Quantity), 0) - COALESCE(SUM(po.Quantity), 0)) AS CurrentStock
    FROM products p
    LEFT JOIN product_ins pi ON p.ProductCode = pi.ProductCode
    LEFT JOIN product_outs po ON p.ProductCode = po.ProductCode
    GROUP BY p.ProductCode, p.ProductName, p.Price
    ORDER BY p.ProductName
");
$products = $stmt->fetchAll();

// Calculate summary statistics
$totalProducts = count($products);
$totalValue = 0;
$totalIn = 0;
$totalOut = 0;

foreach ($products as $product) {
    $totalValue += ($product['CurrentStock'] * $product['Price']);
    $totalIn += $product['TotalIn'];
    $totalOut += $product['TotalOut'];
}

include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management Report</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --dark: #1e1e2c;
            --light: #f8f9fa;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border: #dee2e6;
            --card-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        h3 {
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
        }
        
        .btn-warning {
            background-color: var(--warning);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 12px 15px;
        }
        
        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .table tr:nth-child(even) {
            background-color: var(--light);
        }
        
        .table tr:hover {
            background-color: var(--light-gray);
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .summary-card {
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .summary-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .summary-card h4 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .summary-card p {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .chart-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .chart-card {
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            padding: 20px;
            height: 350px;
        }
        
        .chart-title {
            text-align: center;
            margin-bottom: 15px;
            color: var(--dark);
            font-weight: 600;
        }
        
        .chart-wrapper {
            position: relative;
            height: calc(100% - 40px);
        }
        
        .stock-indicator {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .stock-low {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .stock-medium {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .stock-high {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }
        
        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--light-gray);
        }
        
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .report-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .report-title i {
            background: var(--primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .report-actions {
            display: flex;
            gap: 15px;
        }
        
        .date-filter {
            display: flex;
            gap: 15px;
            align-items: center;
            background: white;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
        }
        
        .date-filter label {
            font-weight: 500;
            color: var(--dark);
        }
        
        .date-filter input {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
        }
        
        .date-filter button {
            padding: 8px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="report-header">
                <div class="report-title">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <h1>Stock Management Report</h1>
                        <p>Comprehensive overview of inventory and stock movements</p>
                    </div>
                </div>
                <div class="report-actions">
                    <button class="btn btn-primary"><i class="fas fa-download"></i> Export PDF</button>
                    <button class="btn btn-primary"><i class="fas fa-print"></i> Print Report</button>
                </div>
            </div>
        </div>
        
        <div class="date-filter">
            <div>
                <label for="start-date">From:</label>
                <input type="date" id="start-date">
            </div>
            <div>
                <label for="end-date">To:</label>
                <input type="date" id="end-date">
            </div>
            <button id="apply-filter"><i class="fas fa-filter"></i> Apply Filter</button>
        </div>
        
        <div class="summary-cards">
            <div class="summary-card">
                <i class="fas fa-boxes"></i>
                <h4><?php echo $totalProducts; ?></h4>
                <p>Total Products</p>
            </div>
            <div class="summary-card">
                <i class="fas fa-arrow-circle-down"></i>
                <h4><?php echo $totalIn; ?></h4>
                <p>Total Stock In</p>
            </div>
            <div class="summary-card">
                <i class="fas fa-arrow-circle-up"></i>
                <h4><?php echo $totalOut; ?></h4>
                <p>Total Stock Out</p>
            </div>
            <div class="summary-card">
                <i class="fas fa-dollar-sign"></i>
                <h4>$<?php echo number_format($totalValue, 2); ?></h4>
                <p>Total Inventory Value</p>
            </div>
        </div>
        
        <div class="card">
            <h3><i class="fas fa-table"></i> Product Stock Details</h3>
            
            <?php if (count($products) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): 
                        $stockClass = '';
                        if ($product['CurrentStock'] == 0) {
                            $stockClass = 'stock-low';
                            $stockText = 'Out of Stock';
                        } elseif ($product['CurrentStock'] < 10) {
                            $stockClass = 'stock-low';
                            $stockText = 'Low Stock';
                        } elseif ($product['CurrentStock'] < 25) {
                            $stockClass = 'stock-medium';
                            $stockText = 'Medium Stock';
                        } else {
                            $stockClass = 'stock-high';
                            $stockText = 'High Stock';
                        }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['ProductCode']); ?></td>
                        <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                        <td>$<?php echo number_format($product['Price'], 2); ?></td>
                        <td><?php echo $product['TotalIn']; ?></td>
                        <td><?php echo $product['TotalOut']; ?></td>
                        <td><?php echo $product['CurrentStock']; ?></td>
                        <td><span class="stock-indicator <?php echo $stockClass; ?>"><?php echo $stockText; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-database"></i>
                <h3>No Product Data Available</h3>
                <p>Add products and stock movements to generate reports</p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="chart-container">
            <div class="chart-card">
                <h4 class="chart-title">Stock Distribution by Product</h4>
                <div class="chart-wrapper">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h4 class="chart-title">Inventory Value by Product</h4>
                <div class="chart-wrapper">
                    <canvas id="valueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set up dates for filter
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        
        document.getElementById('start-date').valueAsDate = firstDay;
        document.getElementById('end-date').valueAsDate = today;
        
        // Prepare data for charts
        const productNames = <?php echo json_encode(array_column($products, 'ProductName')); ?>;
        const currentStocks = <?php echo json_encode(array_column($products, 'CurrentStock')); ?>;
        const inventoryValues = <?php 
            $values = [];
            foreach ($products as $product) {
                $values[] = $product['CurrentStock'] * $product['Price'];
            }
            echo json_encode($values);
        ?>;
        
        // Stock Distribution Chart
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        const stockChart = new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Current Stock',
                    data: currentStocks,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 159, 64)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity'
                        }
                    }
                }
            }
        });
        
        // Inventory Value Chart
        const valueCtx = document.getElementById('valueChart').getContext('2d');
        const valueChart = new Chart(valueCtx, {
            type: 'doughnut',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Inventory Value',
                    data: inventoryValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `$${context.parsed.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
        
        // Filter button functionality
        document.getElementById('apply-filter').addEventListener('click', function() {
            alert('Filter functionality would be implemented here. In a real application, this would reload the page with filtered data.');
        });
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>