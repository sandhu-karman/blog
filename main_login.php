<?php
session_start(); // Start the session at the beginning of the script
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Login Page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

    <!-- Wrapper for centered content -->
    <div id="wrapper">

        <!-- Navigation menu -->
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>

            <?php if (!isset($_SESSION['username'])): ?>
                <!-- Show Register and Login if the user is not logged in -->
                <li><a href="register.php">Register</a></li>
                <li><a href="main_login.php" class="active">Login</a></li>
            <?php else: ?>
                <!-- Show Log Out if the user is logged in -->
                <li><a href="logout.php">Log Out</a></li>
            <?php endif; ?>

            <li><a href="privacy_policy.php">Privacy Policy</a></li>
        </ul>

        <!-- Login Form or Logged-in Message -->
        <div id="all_blogs">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message" style="text-align: center;">
                    <?php echo $_SESSION['error_message']; ?>
                </div>
                <?php unset($_SESSION['error_message']); // Clear the error message ?>
            <?php endif; ?>

            <?php if (!isset($_SESSION['username'])): ?>
                <div id="blogs" class="login-box">
                    <form name="form1" method="post" action="checklogin.php">
                        <h2>Member Login</h2>
                        <div class="input-group">
                            <label for="myusername">Username:</label>
                            <input name="myusername" type="text" id="myusername" required>
                        </div>
                        <div class="input-group">
                            <label for="mypassword">Password:</label>
                            <input name="mypassword" type="password" id="mypassword" required>
                        </div>
                        <div class="input-group">
                            <input type="submit" name="Submit" value="Login">
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <p style="text-align:center;">You are already logged in as <strong><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div id="footer">
            Copywrong 2024 - No Rights Reserved
        </div> <!-- END div id="footer" -->

    </div> <!-- END div id="wrapper" -->

</body>
</html>
