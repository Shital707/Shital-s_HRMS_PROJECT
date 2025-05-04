<?php
include 'config.php';
session_start();

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}

// Get payroll ID from URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid payroll ID.");
}

// Fetch existing payroll data
$sql = "SELECT * FROM payroll WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Payroll record not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $pay_date = mysqli_real_escape_string($conn, $_POST['pay_date']); // Corrected field

    $sql = "UPDATE payroll SET salary = ?, pay_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsi", $salary, $pay_date, $id);

    if ($stmt->execute()) {
        header("Location: view_payroll.php");
        exit();
    } else {
        echo "Error updating payroll: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payroll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Payroll</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
        
        <div class="mb-3">
            <label>Salary:</label>
            <input type="number" name="salary" class="form-control" value="<?= htmlspecialchars($row['salary']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label>Pay Date:</label>
            <input type="date" name="pay_date" class="form-control" value="<?= htmlspecialchars($row['pay_date']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Payroll</button>
        <a href="view_payroll.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
