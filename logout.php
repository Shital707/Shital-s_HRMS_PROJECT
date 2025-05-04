<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session completely
session_destroy();

// Clear session cookies for added security
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect to the login page with a success message
header("Location: login.php?logout=success");
exit();
?>
