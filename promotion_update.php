<?php
// promotion_update.php

// Include the database connection file
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_promotion') {
    // Retrieve form data
    $description = $_POST['description'];
    $discounted_price = $_POST['discounted_price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $requirement = $_POST['requirement'];

    // Handle file upload
    $target_dir = "promotions/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO promotions (description, discounted_price, start_date, end_date, requirement, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssss", $description, $discounted_price, $start_date, $end_date, $requirement, $target_file);
        $stmt->execute();
        $stmt->close();
        
        // Redirect to avoid form resubmission
        header("Location: promotion_update.php");
        exit;
    } else {
        echo "Error uploading file.";
    }
}

// Fetch promotions to display
$result = $conn->query("SELECT * FROM promotions");

// HTML and Bootstrap for the promotion update page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Update</title>
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
                        <a class="nav-link active" href="promotion_update.php">Promotion Update Page</a>
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
        <h2>Add New Promotion</h2>
        <form action="promotion_update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_promotion">
            <div class="mb-3">
                <label for="promotionDescription" class="form-label">Description</label>
                <textarea class="form-control" id="promotionDescription" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="promotionDiscountedPrice" class="form-label">Discounted Price</label>
                <input type="number" step="0.01" class="form-control" id="promotionDiscountedPrice" name="discounted_price" required>
            </div>
            <div class="mb-3">
                <label for="promotionStartDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="promotionStartDate" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="promotionEndDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="promotionEndDate" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="promotionRequirement" class="form-label">Requirement</label>
                <input type="text" class="form-control" id="promotionRequirement" name="requirement" required>
            </div>
            <div class="mb-3">
                <label for="promotionImage" class="form-label">Promotion Image</label>
                <input type="file" class="form-control" id="promotionImage" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Promotion</button>
        </form>

        <h2 class="mt-5">Existing Promotions</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Discounted Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Requirement</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['discounted_price']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                    <td><?php echo $row['requirement']; ?></td>
                    <td><img src="<?php echo $row['image']; ?>" width="100"></td>
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
