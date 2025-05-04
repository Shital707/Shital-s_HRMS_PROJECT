<?php
session_start();
include 'config.php';

// Ensure employee is logged in
$emp_name = $_SESSION['user_name'] ?? null;
if (!$emp_name) {
    echo "<script>alert('Access Denied. Please log in.'); window.location.href='login.php';</script>";
    exit();
}

// Fetch leave requests for logged-in employee
$sql = "SELECT * FROM leaves WHERE emp_id = (SELECT id FROM employees WHERE name = ?) ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $emp_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Leave Status</title>
    <link rel="stylesheet" href="leave_status.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="leave-container">
        <h1>My Leave Requests</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['leave_type']; ?></td>
                <td><?= $row['start_date']; ?></td>
                <td><?= $row['end_date']; ?></td>
                <td><?= $row['reason']; ?></td>
                <td 
                    style="color: <?= ($row['status'] == 'Approved') ? 'green' : (($row['status'] == 'Rejected') ? 'red' : 'orange'); ?>; 
                           font-weight: bold;">
                    <?= $row['status']; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="emp_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
