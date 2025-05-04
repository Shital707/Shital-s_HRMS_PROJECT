<?php
@include 'config.php';
session_start();

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="blurred-background">
</div>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h1>Dashboard</h1>
        <div class="profile">
            <p>Welcome, <span><?php echo $_SESSION['user_name']; ?></span></p>
        </div>
        <P>-----------------<p>
        <ul>
        <li><a href="emp_profile.php">Profile</a></li>
            <li><a href="my_salary.php">Payroll</a></li>
            <li><a href="leave_req.php">Leave Requests</a></li>
            <li><a href="leave_status.php">Leave Status</a></li>
            <li><a href="emp_about.php">About</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
</div>

</body>
</html>
