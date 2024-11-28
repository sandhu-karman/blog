<?php
ob_start();
session_start();
require 'config.php';
require 'database.php';
$g_title = BLOG_NAME . ' - Admin';
$g_page = 'admin';
require 'header.php';
require 'menu.php';

error_reporting(E_ALL ^ E_DEPRECATED);

use PhpRbac\Rbac;
$rbac = new Rbac();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get Role Id
$role_id = $rbac->Roles->returnId('admin');

// Check if User has 'admin' Role
if ($rbac->Users->hasRole($role_id, $_SESSION['id'])) {
    $var_testoutput = "<p>You are admin, and should be here.</p>";
} else {
    // Redirect non-admin users
    header("Location: access_denied.php");
    exit();
}

?>

<div id="all_blogs">
    <table width="300" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td>
                This is the Admin page
                <?php echo $var_testoutput; ?>
            </td>
        </tr>
    </table>
</div>

<?php
require 'footer.php';
?>
