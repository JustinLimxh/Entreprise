<?php
// admin_sales_report.php

// Include the database connection file
require_once 'config.php';

// Fetch monthly sales data
$query = "
    SELECT DATE_FORMAT(orders.order_date, '%Y-%m') AS month, 
           SUM(order_items.quantity * order_items.price) AS total_sales 
    FROM orders
    JOIN order_items ON orders.id = order_items.order_id
    WHERE orders.status = 'Completed'
    GROUP BY month
    ORDER BY month";
    
$result = $conn->query($query);

$months = [];
$sales = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $sales[] = $row['total_sales'];
}

$conn->close();

// Convert data to JSON
$months_json = json_encode($months);
$sales_json = json_encode($sales);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sales Analytics Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_accounts.php">User Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_sales_report.php">Admin Sales Analytics Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="check_user_order.php">User Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="promotion_update.php">Promotion Update Page</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Monthly Sales Analytics Report</h2>
        <canvas id="salesChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Data from PHP
        const months = <?php echo $months_json; ?>;
        const sales = <?php echo $sales_json; ?>;

        // Chart.js initialization
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Total Sales',
                    data: sales,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            // Implement logout functionality
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
