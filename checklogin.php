<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Winnipeg");

//var_dump(date('Y-m-d h:i:s'));die();

session_start();
require 'config.php';
require 'database.php'; // Ensure $db is initialized properly
$g_title = BLOG_NAME . ' - Login';
require 'header.php';
require 'menu.php';

// Database connection (use PDO as recommended)
$host = "localhost"; 
$username = "bloguser"; 
$password = "password"; 
$db_name = "blog"; 
$tbl_name = "members"; 

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// User input
$myusername = $_POST['myusername'] ?? '';
$mypassword = $_POST['mypassword'] ?? '';
$cleanusername = htmlspecialchars($myusername, ENT_QUOTES, 'UTF-8');
$cleanpassword = htmlspecialchars($mypassword, ENT_QUOTES, 'UTF-8');

// Lockout settings
$total_failed_login = 3; 
$lockout_time = 15; // In minutes

// Fetch user data from the database
$stmt = $db->prepare('SELECT id, password, failed_login, last_login FROM members WHERE username = :username LIMIT 1');
$stmt->bindParam(':username', $cleanusername, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Debugging: Show the raw database values
// echo "<pre>"; // Format the output
// var_dump($row);
// echo "</pre>";

if ($row) {
    $failed_login = (int)$row['failed_login'];
    $last_login = strtotime($row['last_login']);
    $timeout = $last_login + ($lockout_time * 60);
    $timenow = time();

    // Debugging: Check the values of important variables
    // echo "<pre>"; // Format the output
    // var_dump($failed_login);
    //var_dump($row['last_login']);
    //var_dump(date('Y-m-d h:i:s',$timeout));
    //var_dump(date('Y-m-d h:i:s',$timenow));
    // echo "</pre>";

    // Check to see if the user has been locked out.
    if( $row[ 'failed_login' ] >= $total_failed_login )  {
        $remaining_time = ceil(($timeout - $timenow) / 60);
        echo "Your account is locked. Try again in $remaining_time minutes.";
        exit();
    }

    if (password_verify($cleanpassword, $row['password'])) {
        $_SESSION['username'] = $cleanusername;
        $_SESSION['id'] = $row['id'];

        // Reset failed login count
        $stmt = $db->prepare('UPDATE members SET failed_login = 0, last_login = NOW() WHERE username = :username');
        $stmt->bindParam(':username', $cleanusername, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: login_success.php");
        exit();
    } else {
        // Update failed login count
        $stmt = $db->prepare('UPDATE members SET failed_login = failed_login + 1, last_login = NOW() WHERE username = :username');
        $stmt->bindParam(':username', $cleanusername, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['error_message'] = "Incorrect Username or Password";
        header("Location: main_login.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No user found with that username";
    header("Location: main_login.php");
    exit();
}

require 'footer.php';
?>
