<?php
// admin.php

// Include the database connection file
require_once 'config.php';

// Function to sanitize input data
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($input)));
}

// Check if the form is submitted to add, edit, or delete a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_product') {
        // Handle adding a new product
        // (Code remains the same as before)
    } elseif ($_POST['action'] == 'update_product') {
        // Handle updating an existing product
        // (Code remains the same as before)
    } elseif ($_POST['action'] == 'delete_product') {
        // Handle deleting a product
        // (Code remains the same as before)
    } elseif ($_POST['action'] == 'update_stock') {
        // Handle updating product stock
        // (Code remains the same as before)
    }
}

// Fetch products to display
$result = $conn->query("SELECT * FROM products");

// Check if edit mode is active to pre-fill the form fields
$product_id = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $product_id = intval($_POST['edit_product']);
}

// Function to fetch product details by ID
function getProductById($conn, $id) {
    $id = intval($id);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

// HTML and Bootstrap for the admin page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="user_accounts.php"> User Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_sales_report.php">Admin Sales Analytics Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="check_user_order.php"> User Order</a>
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
        <h2>Add New Product</h2>
        <form action="process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_product">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="productDescription" class="form-label">Description</label>
                <textarea class="form-control" id="productDescription" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="productPrice" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
            </div>
            <div class="mb-3">
                <label for="productStock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="productStock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="productImage" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="productImage" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <?php if ($product_id !== null) {
            // Fetch product details for editing
            $product = getProductById($conn, $product_id);
            if ($product) { ?>
                <h2>Edit Product</h2>
                <form action="process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_product">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="name" value="<?php echo $product['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editProductDescription" name="description" required><?php echo $product['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPrice" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="editProductPrice" name="price" value="<?php echo $product['price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="editProductStock" name="stock" value="<?php echo $product['stock']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="editProductImage" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            <?php } else {
                echo "<p>Product not found.</p>";
            }
        } ?>

        <h2 class="mt-5">Existing Products</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td>
                        <!-- Form for updating stock -->
                        <form action="process.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="action" value="update_stock">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <input type="number" class="form-control form-control-sm" name="stock" value="<?php echo $row['stock']; ?>" style="width: 70px; display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-primary">Update Stock</button>
                        </form>
                    </td>
                    <td><img src="<?php echo $row['image']; ?>" width="100"></td>
                    <td>
                        <!-- Form for editing product -->
                        <form action="admin.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="edit_product" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                        </form>
                        <!-- Form for deleting product -->
                        <form action="process.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            // Implement logout functionality
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
