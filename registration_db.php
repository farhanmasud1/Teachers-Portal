<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Default password for local development, change if needed
$dbname = "st_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $user = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $pass = $_POST['password']; // Store the password without hashing

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the dashboard after successful registration
        header("Location: r_dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>