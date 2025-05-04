<?php
include 'config.php';
session_start();

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_name'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="blurred-background">
</div>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h1>HRMS</h1>
        <div class="profile">
            <p>Welcome, <span><?php echo $_SESSION['admin_name']; ?></span></p>
        </div>
        <P>-----------------<p>
        <ul>
        <li><a href="hr_profile.php">Profile</a></li>
            <li><a href="manage_emp.php">Manage Employee</a></li>
            <li><a href="manage_leaves.php">Manage leaves</a></li>
            <li><a href="payroll.php">Payroll</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
