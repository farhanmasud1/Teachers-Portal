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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $profession = $conn->real_escape_string($_POST['profession']);
    $research_interest = $conn->real_escape_string($_POST['research_interest']);
    $professional_experience = $conn->real_escape_string($_POST['professional_experience']);
    $membership = $conn->real_escape_string($_POST['membership']);
    $research_activities = $conn->real_escape_string($_POST['research_activities']);
    $publication = $conn->real_escape_string($_POST['publication']);
    $courses_taught = $conn->real_escape_string($_POST['courses_taught']);
    $awards = $conn->real_escape_string($_POST['awards']);
    $other = $conn->real_escape_string($_POST['other']);
    
    // Education details
    $msc_degree_name = $conn->real_escape_string($_POST['msc_degree_name']);
    $msc_group = $conn->real_escape_string($_POST['msc_group']);
    $msc_board = $conn->real_escape_string($_POST['msc_board']);
    $msc_country = $conn->real_escape_string($_POST['msc_country']);
    $msc_passing_year = (int)$_POST['msc_passing_year'];

    $bsc_degree_name = $conn->real_escape_string($_POST['bsc_degree_name']);
    $bsc_group = $conn->real_escape_string($_POST['bsc_group']);
    $bsc_board = $conn->real_escape_string($_POST['bsc_board']);
    $bsc_country = $conn->real_escape_string($_POST['bsc_country']);
    $bsc_passing_year = (int)$_POST['bsc_passing_year'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    // Check if the upload was successful
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = $conn->real_escape_string($target_file);
    } else {
        die("Error uploading image.");
    }

    // Check if the user has already submitted their information
    $email = $_SESSION['user_email']; // Assuming the logged-in user's email is stored in the session
    $check_query = "SELECT * FROM user_information WHERE email = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Information already exists
        echo "You have already submitted your information.";
    } else {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO user_information 
            (email, full_name, image_path, mobile, profession, research_interest, professional_experience, membership, research_activities, publication, courses_taught, awards, other, msc_degree_name, msc_group, msc_board, msc_country, msc_passing_year, bsc_degree_name, bsc_group, bsc_board, bsc_country, bsc_passing_year) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssssssssssssssss", 
            $email, $full_name, $image_path, $mobile, $profession, $research_interest, $professional_experience, $membership, $research_activities, $publication, $courses_taught, $awards, $other, 
            $msc_degree_name, $msc_group, $msc_board, $msc_country, $msc_passing_year, 
            $bsc_degree_name, $bsc_group, $bsc_board, $bsc_country, $bsc_passing_year
        );

        if ($stmt->execute()) {
            echo "Information saved successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close connection
        $stmt->close();
    }

    // Close the check statement
    $stmt_check->close();
    $conn->close();
}
?>
