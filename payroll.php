<?php
session_start();
@include 'config.php';

// Fetch employees for dropdown
$employees = $conn->query("SELECT id, name FROM employees");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'];
    $salary = $_POST['salary'];
    $pay_date = $_POST['pay_date'];

    $sql = "INSERT INTO payroll (emp_id, salary, pay_date) VALUES ('$emp_id', '$salary', '$pay_date')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Salary added successfully!</p>";
        header("Location: view_payroll.php");
        exit(); // Stop further execution
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="payroll_style.css">
</head>
<body>
<div class="blurred-background">
</div>
<h1>Add Employee Salary</h1>
<form method="POST">
    <label>Select Employee:</label>
    <select name="emp_id" required>
        <option value="">-- Select Employee --</option>
        <?php while ($row = $employees->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Salary:</label>
    <input type="number" name="salary" required><br><br>

    <label>Pay Date:</label>
    <input type="date" name="pay_date" required><br><br>

    <button type="submit">Submit Salary</button>
    <a href="view_payroll.php" class="btn btn2">View Payroll Details..</a>
</form>
</body>
</html>