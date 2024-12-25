<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Adjust if needed
$dbname = "st_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $email = htmlspecialchars($_POST['email']);
    $pass = $_POST['password']; // For production, hash verification is recommended

    // Prepare SQL statement to check user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['user_email'] = $email; // Store user info in session
        header("Location: t_info.php"); // Redirect to dashboard
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>