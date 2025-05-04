<?php
session_start();
include 'config.php';

// Ensure employee is logged in
if (!isset($_SESSION['user_name'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='login.php';</script>";
    exit();
}

$emp_name = $_SESSION['user_name'];

// Fetch employee ID based on user_name
$query = "SELECT id FROM employees WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $emp_name);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    echo "<script>alert('Employee record not found.');</script>";
    exit();
}

$emp_id = $employee['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_type = $_POST['leave_type'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $reason = $_POST['reason'] ?? '';

    // Validate form input
    if (empty($leave_type) || empty($start_date) || empty($end_date) || empty($reason)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (strtotime($start_date) > strtotime($end_date)) {
        echo "<script>alert('End date must be after start date.');</script>";
    } else {
        // Insert leave request into `leave_requests` table
        $query = "INSERT INTO leaves (emp_id, leave_type, start_date, end_date, reason, status) 
                  VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $emp_id, $leave_type, $start_date, $end_date, $reason);

        if ($stmt->execute()) {
            echo "<script>alert('Leave request submitted successfully!'); window.location.href='leave_status.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Request</title>
    <link rel="stylesheet" type="text/css" href="leave_req.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="leave-container">
        <h2>Apply for Leave</h2>
        <form method="POST">
            <label>Leave Type:</label>
            <select name="leave_type" required>
                <option value="Casual Leave">Casual Leave</option>
                <option value="Sick Leave">Sick Leave</option>
                <option value="Paid Leave">Paid Leave</option>
            </select><br>

            <label>Start Date:</label>
            <input type="date" name="start_date" required><br>

            <label>End Date:</label>
            <input type="date" name="end_date" required><br>

            <label>Reason:</label>
            <input type="text" name="reason" required><br>

            <button type="submit">Apply</button>
        </form>
        <br>
        <a href="emp_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
