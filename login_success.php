<?php
  session_start(); // Start the session at the very beginning

  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - Login Successful';
  $g_page = 'login'; // This can be updated to 'index' if needed
  require 'header.php'; // Include the header file
  require 'menu.php';   // Include the menu file

  // Check if the user is logged in
  if (!isset($_SESSION['username'])) {
      header("location:login.php");
      exit();
  }
?>

<div id="all_blogs" style="text-align: center;">
    <p>Login Successful</p>
    <!-- Meta tag to redirect after 1 second -->
    <meta http-equiv="refresh" content="1;url=index.php">
</div>

<?php
  require 'footer.php'; // Include the footer file
?>
