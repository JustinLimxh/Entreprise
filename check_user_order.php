<?php
// check_user_order.php

// Include the database connection file
require_once 'config.php'; // Adjust the path as per your file structure

// Fetch orders to display
$query = "
    SELECT orders.*, 
           users.username AS user_name, 
           users.address AS user_address, 
           users.contact_number AS user_contact, 
           products.name AS product_name 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    JOIN products ON orders.product_id = products.id";

$result = $conn->query($query);

// Handle update status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    // Prepare and execute update statement
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to avoid form resubmission
    header("Location: check_user_order.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check User Orders</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Adjust the path to your CSS file -->
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
                        <a class="nav-link" href="admin_sales_report.php">Admin Sales Analytics Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="check_user_order.php">User Order</a>
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
        <h2>User Orders</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['user_address']; ?></td>
                        <td><?php echo $row['user_contact']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['total_amount']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td>
                            <form action="check_user_order.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No user orders found.</p>
        <?php } ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: JavaScript for logout function -->
    <script>
        function logout() {
            // Implement logout functionality
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
