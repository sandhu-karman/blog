<?php
ob_start();
require 'config.php';
require 'database.php';
$g_title = BLOG_NAME . ' - Register';
require 'header.php';
require 'menu.php';

$host = "localhost"; // Host name
$username = "bloguser"; // MySQL username
$password = "password"; // MySQL password
$db_name = "blog"; // Database name
$tbl_name = "members"; // Table name

$mysqli = new mysqli($host, $username, $password, $db_name);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];

// To protect MySQL injection
$cleanusername = $mysqli->real_escape_string($myusername);
$cleanpassword = $mysqli->real_escape_string($mypassword);

// Salting adds uniqueness to each entry.
$salt = uniqid();
$salted_password = $salt . $cleanpassword;
$encrypted_password = hash("sha512", $salted_password);

$sql = "INSERT INTO $tbl_name (username, password, salt) VALUES ('$cleanusername', '$encrypted_password', '$salt')";

if (!$mysqli->query($sql)) {
    echo "<div id='all_blogs' style='text-align: center; padding: 20px; color: red;'>";
    echo "<h2>Registration Failed!</h2>";
    echo "<p>Error: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
    echo "</div>";
} else {
    // Display success message and redirect after 1 second
    echo "<div id='all_blogs' style='text-align: center; padding: 20px;'>";
    echo "<h2>Registration Successful!</h2>";
    echo "<p>You will be redirected to the login page shortly.</p>";
    echo "</div>";

    // Meta tag for redirect after 1 second
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
}

ob_end_flush();
require 'footer.php';
?>
