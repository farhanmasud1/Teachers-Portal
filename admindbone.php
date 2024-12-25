<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    $admin_username = "admin";
    $admin_password = "123456";

    // Check if the entered credentials are correct
    if ($username == $admin_username && $password == $admin_password) {
        // Set session and redirect to dashboard
        $_SESSION['logged_in'] = true;
        header("Location: admin_db.php");
        exit();
    } else {
        echo "Invalid username or password!";
    }
}
?>