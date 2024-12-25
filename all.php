<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="all.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="table-container">
        <?php
        // Database connection
        $servername = "localhost"; // Hostname
        $username = "root"; // Username
        $password = ""; // Password
        $dbname = "st_registration"; // Database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch data from the user_information table
        $sql = "SELECT * FROM user_information";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Start table and header
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Image</th>
                    <th>Mobile</th>
                    <th>Profession</th>
                    <th>Research Interest</th>
                    <th>Professional Experience</th>
                    <th>Membership</th>
                    <th>Research Activities</th>
                    <th>Publication</th>
                    <th>Courses Taught</th>
                    <th>Awards</th>
                    <th>Other</th>
                    <th>MSC Degree Name</th>
                    <th>BSC Degree Name</th>
                    <th>Created At</th>
                </tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["full_name"] . "</td>
                        <td><img src='" . $row["image_path"] . "' alt='Image' width='100'></td>
                        <td>" . $row["mobile"] . "</td>
                        <td>" . $row["profession"] . "</td>
                        <td>" . $row["research_interest"] . "</td>
                        <td>" . $row["professional_experience"] . "</td>
                        <td>" . $row["membership"] . "</td>
                        <td>" . $row["research_activities"] . "</td>
                        <td>" . $row["publication"] . "</td>
                        <td>" . $row["courses_taught"] . "</td>
                        <td>" . $row["awards"] . "</td>
                        <td>" . $row["other"] . "</td>
                        <td>" . $row["msc_degree_name"] . "</td>
                        <td>" . $row["bsc_degree_name"] . "</td>
                        <td>" . $row["created_at"] . "</td>
                    </tr>";
            }

            // End table
            echo "</table>";
        } else {
            echo "<div class='no-records'>No records found.</div>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
