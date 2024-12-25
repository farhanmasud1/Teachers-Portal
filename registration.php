<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <!-- Admin button outside the form but in the body -->
    <div class="admin-container">
        <button type="button" class="admin-btn" onclick="window.location.href='admin.php'">Admin</button>
    </div> 
    
    <div class="container">
        <h2>Registration Form</h2>
        <form action="registration_db.php" method="post">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
            <p class="account-prompt">Already have an account?</p>
            <button type="button" class="login-btn" onclick="window.location.href='login.php'">Login</button>
        </form>
    </div>
</body>
</html>
