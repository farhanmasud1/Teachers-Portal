<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

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

// Retrieve user information
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Display user information
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Welcome, " . htmlspecialchars($row['username']) . "!</h2>";
    echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
} else {
    echo "<p>Error retrieving user information.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="t_info.css">
</head>
<body>
    

    <!-- Add Information Button -->
    <button onclick="document.getElementById('addInfoForm').style.display='block'">Add Information</button>
    <button onclick="window.location.href='edit.php'">Edit Information</button>
    <button onclick="window.location.href='view_details.php'">View Profiles</button>

    <!-- Add Information Form (Initially Hidden) -->

    <button><a href="logout.php">Logout</a></button> <!-- Simple logout link -->
    <div id="addInfoForm" style="display:none;">
        <h3>Fill out the Information</h3>
        <form action="save_information.php" method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" required><br><br>

            <label for="image">Profile Image:</label>
            <input type="file" name="image" accept="image/*" required><br><br>

            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" required><br><br>

            <label for="profession">Profession:</label>
            <input type="text" name="profession" required><br><br>

            <label for="research_interest">Research Interest:</label>
            <input type="text" name="research_interest" required><br><br>

            <label for="professional_experience">Professional Experience:</label>
            <textarea name="professional_experience" required></textarea><br><br>

            <label for="membership">Membership:</label>
            <input type="text" name="membership" required><br><br>

            <label for="research_activities">Research Activities:</label>
            <textarea name="research_activities" required></textarea><br><br>

            <label for="publication">Publication:</label>
            <input type="text" name="publication" required><br><br>

            <label for="courses_taught">Courses Taught:</label>
            <input type="text" name="courses_taught" required><br><br>

            <label for="awards">Awards:</label>
            <input type="text" name="awards" required><br><br>

            <label for="other">Other:</label>
            <textarea name="other"></textarea><br><br>

            <!-- Education Details Table -->
            <h4>Education Details:</h4>
            <table border="1">
                <thead>
                    <tr>
                        <th>Degree Name</th>
                        <th>Group</th>
                        <th>Board</th>
                        <th>Country</th>
                        <th>Passing Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="msc_degree_name"></td>
                        <td><input type="text" name="msc_group"></td>
                        <td><input type="text" name="msc_board"></td>
                        <td><input type="text" name="msc_country"></td>
                        <td><input type="number" name="msc_passing_year"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="bsc_degree_name"></td>
                        <td><input type="text" name="bsc_group"></td>
                        <td><input type="text" name="bsc_board"></td>
                        <td><input type="text" name="bsc_country"></td>
                        <td><input type="number" name="bsc_passing_year"></td>
                    </tr>
                </tbody>
            </table>
            <br><br>
            <input type="submit" value="Save Information">
        </form>
    </div>
</body>
</html> 