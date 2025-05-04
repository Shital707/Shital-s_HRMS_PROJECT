<?php
session_start();
@include 'config.php';

// Ensure only HR can access this page
if (!isset($_SESSION['admin_name'])) {
    echo "Access Denied! HR login required.";
    exit();
}

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if search query is provided
$search_query = "";
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = $conn->real_escape_string($_GET['search_name']); // Prevent SQL injection
    $search_query = "AND e.name LIKE '%$search_name%'";
}

// Fetch payroll details with employee names
$sql = "SELECT p.payroll_id, e.name AS emp_name, p.salary, p.pay_date 
        FROM payroll p 
        JOIN employees e ON p.emp_id = e.id
        WHERE 1 $search_query
        ORDER BY p.pay_date DESC";

$result = $conn->query($sql);

// Check for SQL errors
if (!$result) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="viewpayroll_style.css">
    <title>HR - View Payroll</title>
</head>
<body>
<div class="blurred-background">
</div>
    <h1>Employee Payroll Details</h1>

    <!-- Search Form -->
    <form method="GET">
        <label>Search by Employee Name:</label>
        <input type="text" name="search_name" value="<?= isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : '' ?>">
        <button type="submit">Search</button>
        <a href="view_payroll.php"><button type="button">Reset</button></a>
    </form>

    <table border="1">
        <tr>
            <th>Payroll ID</th>
            <th>Employee Name</th>
            <th>Salary</th>
            <th>Pay Date</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['payroll_id']) ?></td>
                    <td><?= htmlspecialchars($row['emp_name']) ?></td>
                    <td><?= number_format($row['salary'], 2) ?></td>
                    <td><?= htmlspecialchars($row['pay_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No payroll records found.</td></tr>
        <?php endif; ?>
    </table>
    <a href="hr_dashboard.php"><button type="button">Back to Dashboard</button></a>
</body>
</html>
