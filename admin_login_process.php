<?php
// admin_login_process.php

// Include database connection and other necessary files
require_once 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the login credentials
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Successful login, redirect to dashboard or desired page
            session_start();
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit; // Ensure no further output after redirection
        } else {
            // Invalid password
            header("Location: admin_login.php?error=auth_failed");
            exit; // Ensure no further output after redirection
        }
    } else {
        // Admin with given username not found
        header("Location: admin_login.php?error=auth_failed");
        exit; // Ensure no further output after redirection
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back to login page if accessed directly without POST request
  
    exit; // Ensure no further output after redirection
}
?>
