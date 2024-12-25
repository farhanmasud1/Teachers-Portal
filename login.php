<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
        <form method="POST" action="login_db.php">
            <div class="form-group">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" class="input-field" required><br><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" class="input-field" required><br><br>
            </div>
            <input type="submit" value="Login" class="submit-btn">
        </form>
        <br>
        <p class="account-prompt">Don't have an account?</p>
        <button class="register-btn" onclick="window.location.href='registration.php';">Register</button>
    </div>
</body>
</html>
