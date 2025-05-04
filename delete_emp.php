<?php
include 'config.php';
session_start();

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}

// Validate and sanitize the ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Corrected SQL query
    $sql = "DELETE FROM emp WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_emp.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Employee ID!";
}
?>
