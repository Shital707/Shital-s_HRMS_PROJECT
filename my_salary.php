<?php
session_start();
@include 'config.php';

// Ensure the employee is logged in
if (!isset($_SESSION['user_name'])) {
    echo "Access Denied! Please log in first.";
    exit();
}

$emp_name = $_SESSION['user_name']; // Get employee name from session

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch Employee ID securely
$sql = "SELECT id FROM employees WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $emp_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $emp_id = $row['id'];

    // Fetch payroll details for the logged-in employee
    $sql_payroll = "SELECT payroll_id, salary, pay_date FROM payroll WHERE emp_id = ? ORDER BY pay_date DESC";
    $stmt_payroll = $conn->prepare($sql_payroll);
    $stmt_payroll->bind_param("i", $emp_id);
    $stmt_payroll->execute();
    $result_payroll = $stmt_payroll->get_result();
} else {
    $emp_id = null; // Employee not found
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Salary Details</title>
    <link rel="stylesheet" href="my_salary.css">
</head>
<body>
<div class="blurred-background">
</div>
    <h1>Welcome, <?= htmlspecialchars($emp_name) ?>!</h1>
    <h2>Your Salary Details</h2>
    
    <?php if ($emp_id !== null && $result_payroll->num_rows > 0): ?>
        <table>
            <tr>
                <th>Payroll ID</th>
                <th>Salary (₹)</th>
                <th>Pay Date</th>
            </tr>
            <?php while ($row = $result_payroll->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['payroll_id'] ?></td>
                    <td><?= number_format($row['salary'], 2) ?></td>
                    <td><?= date("d-M-Y", strtotime($row['pay_date'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No salary records found.</p>
    <?php endif; ?>

    <br>
    <a href="emp_dashboard.php" class="btn">Back to Dashboard</a>
    <a href="logout.php" class="btn logout">Logout</a>
</body>
</html>
