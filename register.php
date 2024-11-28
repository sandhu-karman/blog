<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Register Page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php
session_start();

$host = "192.168.56.101"; // Host name
$username = "blogadmin"; // MySQL username
$password = "password"; // MySQL password
$db_name = "blog"; // Database name
$tbl_name = "members"; // Table name

// Create connection
$mysqli = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

// Initialize error variable
$error = "";

// Check if form data exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = trim($_POST['myusername']);
    $mypassword = trim($_POST['mypassword']);
    $verifyPassword = trim($_POST['verifypassword']); // Verify password
    $myemail = trim($_POST['email']); // Email

    // Ensure all fields are filled
    if (!empty($myusername) && !empty($mypassword) && !empty($verifyPassword) && !empty($myemail)) {
        // Validate email format
        if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else if ($mypassword !== $verifyPassword) {
            $error = "Passwords do not match.";
        } else {
            // Check if username already exists in the database
            $checkUserStmt = $mysqli->prepare("SELECT username FROM $tbl_name WHERE username = ? OR email = ?");
            $checkUserStmt->bind_param("ss", $myusername, $myemail);
            $checkUserStmt->execute();
            $checkUserStmt->store_result();

            if ($checkUserStmt->num_rows > 0) {
                $error = "Username or email already exists, please choose another one.";
            } else {
                // Use password_hash to hash the password securely
                $hashed_password = password_hash($mypassword, PASSWORD_BCRYPT);

                // Use prepared statements to insert new user securely
                $stmt = $mysqli->prepare("INSERT INTO $tbl_name (username, password, email) VALUES (?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sss", $myusername, $hashed_password, $myemail);

                    // Execute the query
                    if ($stmt->execute()) {
                        // Auto-login after registration or redirect to login page
                        $_SESSION['username'] = $myusername;
                        echo "<p style='color: green;'>Registration successful. Redirecting to home page...</p>";
                        
                        // Redirect to a login_success or index page after 3 seconds
                        header("refresh:3;url=index.php");
                    } else {
                        $error = "Registration failed: (" . $stmt->errno . ") " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
            }
            $checkUserStmt->close();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
$mysqli->close();
?>

<!-- Navigation Menu -->
<div id="wrapper">
    <?php include 'menu.php'; ?>

    <h2>Register</h2>

    <!-- Display error if set -->
    <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Register Form -->
    <form method="POST" action="register.php">
        <fieldset>
            <label for="myusername">Username:</label>
            <input name="myusername" type="text" id="myusername" required>

            <label for="email">Email:</label>
            <input name="email" type="email" id="email" required>

            <label for="mypassword">Password:</label>
            <input name="mypassword" type="password" id="mypassword" required>

            <label for="verifypassword">Verify Password:</label>
            <input name="verifypassword" type="password" id="verifypassword" required>

            <input type="submit" name="Submit" value="Register">
        </fieldset>
    </form>
</div> <!-- END div id="wrapper" -->

</body>
</html>
