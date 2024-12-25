<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
     <link rel="stylesheet" href="admin_db.css">
</head>
<body>
    <div class="container">
        <h2>Welcome to Admin Dashboard</h2>
        <p>You are logged in as an admin.</p>
        <a href="all.php">View All Teachers Information</a><br>
        <a href="admin.php?logout=true" class="logout">Logout</a>
    </div>

    <?php
    // Handle logout
    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: admin.php");
        exit();
    }
    ?>
</body>
</html>
