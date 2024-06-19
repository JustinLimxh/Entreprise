<?php
// process.php

// Include the database connection file
require_once 'config.php';

// Function to sanitize input data
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($input)));
}

// Check if the form is submitted to add, edit, or delete a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_product') {
        // Retrieve and sanitize form data
        $name = sanitize($conn, $_POST['name']);
        $description = sanitize($conn, $_POST['description']);
        $price = floatval($_POST['price']); // Convert to float
        $stock = intval($_POST['stock']); // Convert to integer

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdis", $name, $description, $price, $stock, $target_file); // Use 'ssdis' for string, string, double, integer, string
            $stmt->execute();
            $stmt->close();
            
            // Redirect to avoid form resubmission
            header("Location: admin.php");
            exit;
        } else {
            echo "Error uploading file.";
        }
    } elseif ($_POST['action'] == 'update_product') {
        // Retrieve and sanitize form data
        $id = intval($_POST['product_id']);
        $name = sanitize($conn, $_POST['name']);
        $description = sanitize($conn, $_POST['description']);
        $price = floatval($_POST['price']); // Convert to float
        $stock = intval($_POST['stock']); // Convert to integer

        // Check if image is updated
        if ($_FILES['image']['size'] > 0) {
            // Handle file upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            // Create directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Update product with new image
                $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
                $stmt->bind_param("ssdisi", $name, $description, $price, $stock, $target_file, $id);
                $stmt->execute();
                $stmt->close();
                
                // Redirect to avoid form resubmission
                header("Location: admin.php");
                exit;
            } else {
                echo "Error uploading file.";
            }
        } else {
            // Update product without changing the image
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
            $stmt->bind_param("ssdii", $name, $description, $price, $stock, $id);
            $stmt->execute();
            $stmt->close();
            
            // Redirect to avoid form resubmission
            header("Location: admin.php");
            exit;
        }
    } elseif ($_POST['action'] == 'delete_product') {
        // Retrieve and sanitize product ID
        $id = intval($_POST['product_id']);

        // Delete product from database
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Redirect to avoid form resubmission
        header("Location: admin.php");
        exit;
    } elseif ($_POST['action'] == 'update_stock') {
        // Retrieve and sanitize form data
        $id = intval($_POST['product_id']);
        $stock = intval($_POST['stock']);

        // Update product stock in database
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $stock, $id);
        $stmt->execute();
        $stmt->close();
        
        // Redirect to avoid form resubmission
        header("Location: admin.php");
        exit;
    }
}

// Close database connection
$conn->close();
?>
