<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Enhanced security for session management
if (!isset($_SESSION['hr_id'])) {
    header("Location: login.php");
    exit();
}
session_regenerate_id(true); // Ensures a fresh session ID after login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="style.php">
</head>
<body>
    <div class="sidebar">
        <a href="manage_emp.php">Manage Employees</a>
        <a href="add_emp.php">Add Employee</a>
        <a href="payroll.php">Payroll</a>
        <a href="leaves.php">Leaves</a>
        <a href="profiles.php">Profile</a>  <!-- Corrected Profile Link -->
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h1>Welcome to the HR Dashboard!</h1>
        <p>Use the sidebar to manage employees, payroll, leaves, and profiles.</p>
        
        <div class="dashboard-info">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="manage_emp.php">View and Manage Employees</a></li>
                <li><a href="add_emp.php">Add New Employee</a></li>
                <li><a href="payroll.php">View Payroll Details</a></li>
                <li><a href="leaves.php">Manage Leave Requests</a></li>
                <li><a href="profiles.php">Edit Your Profile</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
