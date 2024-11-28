<?php
session_start(); // Start session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
        <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div id="wrapper">

<!-- Navigation Menu -->
<ul id="menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="privacy_policy.php">Privacy Policy</a></li>
    <li><a href="register.php">Register</a></li>
    <li><a href="main_login.php">Login</a></li>
</ul>

<!-- Content Wrapper -->

    <h2>Logout successful.</h2>
    </div>

</body>
</html>
