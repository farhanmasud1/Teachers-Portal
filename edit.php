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

// Get user email from session
$email = $_SESSION['user_email'];

// Retrieve current data for the user
$query = $conn->prepare("SELECT * FROM user_information WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user_data = $result->fetch_assoc();

if (!$user_data) {
    die("No user information found.");
}

// Check if the form is submitted for updating
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

    // Handle image upload if a new file is provided
    $image_path = $user_data['image_path']; // Existing image path
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $conn->real_escape_string($target_file);
        } else {
            die("Error uploading image.");
        }
    }

    // Update data in the database
    $stmt = $conn->prepare("UPDATE user_information SET 
        full_name = ?, image_path = ?, mobile = ?, profession = ?, research_interest = ?, professional_experience = ?, membership = ?, 
        research_activities = ?, publication = ?, courses_taught = ?, awards = ?, other = ?, msc_degree_name = ?, msc_group = ?, 
        msc_board = ?, msc_country = ?, msc_passing_year = ?, bsc_degree_name = ?, bsc_group = ?, bsc_board = ?, bsc_country = ?, 
        bsc_passing_year = ? WHERE email = ?");

    $stmt->bind_param("sssssssssssssssssssssss", 
        $full_name, $image_path, $mobile, $profession, $research_interest, $professional_experience, $membership, 
        $research_activities, $publication, $courses_taught, $awards, $other, $msc_degree_name, $msc_group, $msc_board, 
        $msc_country, $msc_passing_year, $bsc_degree_name, $bsc_group, $bsc_board, $bsc_country, $bsc_passing_year, $email
    );

    if ($stmt->execute()) {
        echo "Information updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <h1>Edit Your Information</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" required><br>

        <!-- Image upload field -->
        <label for="image">Profile Image:</label>
        <input type="file" name="image" id="image"><br>

        <label for="mobile">Mobile:</label>
        <input type="text" name="mobile" id="mobile" value="<?php echo htmlspecialchars($user_data['mobile']); ?>" required><br>

        <label for="profession">Profession:</label>
        <input type="text" name="profession" id="profession" value="<?php echo htmlspecialchars($user_data['profession']); ?>" required><br>

        <label for="research_interest">Research Interest:</label>
        <input type="text" name="research_interest" id="research_interest" value="<?php echo htmlspecialchars($user_data['research_interest']); ?>" required><br>

        <label for="professional_experience">Professional Experience:</label>
        <input type="text" name="professional_experience" id="professional_experience" value="<?php echo htmlspecialchars($user_data['professional_experience']); ?>" required><br>

        <label for="membership">Membership:</label>
        <input type="text" name="membership" id="membership" value="<?php echo htmlspecialchars($user_data['membership']); ?>" required><br>

        <label for="research_activities">Research Activities:</label>
        <input type="text" name="research_activities" id="research_activities" value="<?php echo htmlspecialchars($user_data['research_activities']); ?>" required><br>

        <label for="publication">Publication:</label>
        <input type="text" name="publication" id="publication" value="<?php echo htmlspecialchars($user_data['publication']); ?>" required><br>

        <label for="courses_taught">Courses Taught:</label>
        <input type="text" name="courses_taught" id="courses_taught" value="<?php echo htmlspecialchars($user_data['courses_taught']); ?>" required><br>

        <label for="awards">Awards:</label>
        <input type="text" name="awards" id="awards" value="<?php echo htmlspecialchars($user_data['awards']); ?>" required><br>

        <label for="other">Other:</label>
        <input type="text" name="other" id="other" value="<?php echo htmlspecialchars($user_data['other']); ?>"><br>

        <!-- Education details for MSc and BSc -->
        <label for="msc_degree_name">MSc Degree Name:</label>
        <input type="text" name="msc_degree_name" id="msc_degree_name" value="<?php echo htmlspecialchars($user_data['msc_degree_name']); ?>" required><br>

        <label for="msc_group">MSc Group:</label>
        <input type="text" name="msc_group" id="msc_group" value="<?php echo htmlspecialchars($user_data['msc_group']); ?>" required><br>

        <label for="msc_board">MSc Board:</label>
        <input type="text" name="msc_board" id="msc_board" value="<?php echo htmlspecialchars($user_data['msc_board']); ?>" required><br>

        <label for="msc_country">MSc Country:</label>
        <input type="text" name="msc_country" id="msc_country" value="<?php echo htmlspecialchars($user_data['msc_country']); ?>" required><br>

        <label for="msc_passing_year">MSc Passing Year:</label>
        <input type="number" name="msc_passing_year" id="msc_passing_year" value="<?php echo htmlspecialchars($user_data['msc_passing_year']); ?>" required><br>

        <label for="bsc_degree_name">BSc Degree Name:</label>
        <input type="text" name="bsc_degree_name" id="bsc_degree_name" value="<?php echo htmlspecialchars($user_data['bsc_degree_name']); ?>" required><br>

        <label for="bsc_group">BSc Group:</label>
        <input type="text" name="bsc_group" id="bsc_group" value="<?php echo htmlspecialchars($user_data['bsc_group']); ?>" required><br>

        <label for="bsc_board">BSc Board:</label>
        <input type="text" name="bsc_board" id="bsc_board" value="<?php echo htmlspecialchars($user_data['bsc_board']); ?>" required><br>

        <label for="bsc_country">BSc Country:</label>
        <input type="text" name="bsc_country" id="bsc_country" value="<?php echo htmlspecialchars($user_data['bsc_country']); ?>" required><br>

        <label for="bsc_passing_year">BSc Passing Year:</label>
        <input type="number" name="bsc_passing_year" id="bsc_passing_year" value="<?php echo htmlspecialchars($user_data['bsc_passing_year']); ?>" required><br>

        <input type="submit" value="Update Information">
    </form>
</body>
</html>
