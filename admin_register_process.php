<?php
// admin_register_process.php

// Include database connection
require_once 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL query to insert data into admin table
    $stmt = $conn->prepare("INSERT INTO admins (username, email, password, department) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $department);
    
    if ($stmt->execute()) {
        // Registration successful
        header("Location: admin_login.php");
        exit;
    } else {
        // Error in registration
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
