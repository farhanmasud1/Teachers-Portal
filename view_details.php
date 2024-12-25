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

// Get the logged-in user's email
$email = $_SESSION['user_email'];

// Query to fetch user information
$query = "SELECT * FROM user_information WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Display user information
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>User Profile</title>";
    echo "<link rel='stylesheet' href='view_details.css'>"; // Link to the external CSS file
    echo "</head>";
    echo "<body>";

    echo "<div class='profile-container'>";
    echo "<h2>User Profile</h2>";
    echo "<div class='profile-info'>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($user['full_name']) . "</p>";
    
    // Display profile image if available
    if (!empty($user['image_path'])) {
        echo "<div class='profile-image'><img src='" . htmlspecialchars($user['image_path']) . "' alt='Profile Image'></div>";
    }
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    echo "<p><strong>Mobile:</strong> " . htmlspecialchars($user['mobile']) . "</p>";

    // Display Professional Information in a Table
    echo "<h3>Professional Information</h3>";
    echo "<table class='user-info-table'>";
    echo "<thead>";
    echo "<tr><th>Field</th><th>Details</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr><td>Profession</td><td>" . htmlspecialchars($user['profession']) . "</td></tr>";
    echo "<tr><td>Research Interest</td><td>" . htmlspecialchars($user['research_interest']) . "</td></tr>";
    echo "<tr><td>Professional Experience</td><td>" . htmlspecialchars($user['professional_experience']) . "</td></tr>";
    echo "<tr><td>Membership</td><td>" . htmlspecialchars($user['membership']) . "</td></tr>";
    echo "<tr><td>Research Activities</td><td>" . htmlspecialchars($user['research_activities']) . "</td></tr>";
    echo "<tr><td>Publication</td><td>" . htmlspecialchars($user['publication']) . "</td></tr>";
    echo "<tr><td>Courses Taught</td><td>" . htmlspecialchars($user['courses_taught']) . "</td></tr>";
    echo "<tr><td>Awards</td><td>" . htmlspecialchars($user['awards']) . "</td></tr>";
    echo "<tr><td>Other</td><td>" . htmlspecialchars($user['other']) . "</td></tr>";
    echo "</tbody>";
    echo "</table>";

    // Education details - Display as Table
    echo "<h3>Education Details</h3>";
    echo "<table class='education-table'>";
    echo "<thead>";
    echo "<tr><th>Degree</th><th>Group</th><th>Board</th><th>Country</th><th>Passing Year</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    
    // MSC Education Details
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user['msc_degree_name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['msc_group']) . "</td>";
    echo "<td>" . htmlspecialchars($user['msc_board']) . "</td>";
    echo "<td>" . htmlspecialchars($user['msc_country']) . "</td>";
    echo "<td>" . htmlspecialchars($user['msc_passing_year']) . "</td>";
    echo "</tr>";

    // BSC Education Details
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user['bsc_degree_name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['bsc_group']) . "</td>";
    echo "<td>" . htmlspecialchars($user['bsc_board']) . "</td>";
    echo "<td>" . htmlspecialchars($user['bsc_country']) . "</td>";
    echo "<td>" . htmlspecialchars($user['bsc_passing_year']) . "</td>";
    echo "</tr>";
    
    echo "</tbody>";
    echo "</table>";

    echo "</div>"; // Close profile-info
    echo "</div>"; // Close profile-container

    echo "</body>";
    echo "</html>";
}
else {
    echo "No information found for this user.";
}

// Close connection
$stmt->close();
$conn->close();
?>
