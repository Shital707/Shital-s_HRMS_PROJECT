<?php
include 'config.php';
session_start();

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}

// Validate and fetch employee ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Employee ID");
}

$id = $_GET['id'];

// Fetch employee details securely
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Employee not found.");
}

$row = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department']; // Fixed name
    $work = $_POST['work'];
    $position = $_POST['position']; // Fixed name
    $gender = $_POST['gender'];
    $address = $_POST['address']; // Fixed name

    // Update query using prepared statements
    $update_sql = "UPDATE employees SET name=?, email=?, department=?, work=?, position=?, gender=?, address=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssi", $name, $email, $department, $work, $position, $gender, $address, $id);

    if ($update_stmt->execute()) {
        header("Location: manage_emp.php");
        exit();
    } else {
        echo "Error: " . $update_stmt->error; // More specific error reporting
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title> <!-- Fixed Title -->
    <link rel="stylesheet" type="text/css" href="rstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="container">
        <form action="" method="POST">
            <h2>Edit Employee</h2> <!-- Fixed Title -->

            <div class="form-container">
                <div class="input-name">
                <i class="fa fa-user lock"></i>
                    <input type="text" placeholder="Full Name" name="name" class="name" value="<?= htmlspecialchars($row['name']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-envelope lock"></i>
                    <input type="email" placeholder="Email" name="email" class="text-name" value="<?= htmlspecialchars($row['email']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-building lock"></i>
                    <input type="text" placeholder="Department" name="department" class="text-name" value="<?= htmlspecialchars($row['department']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-briefcase lock"></i>
                    <input type="text" placeholder="Work" name="work" class="text-name" value="<?= htmlspecialchars($row['work']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-user-tie lock"></i>
                    <input type="text" placeholder="Position" name="position" class="text-name" value="<?= htmlspecialchars($row['position']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-solid fa-person-half-dress lock"></i>
                    <input type="text" placeholder="Gender" name="gender" class="text-name" value="<?= htmlspecialchars($row['gender']); ?>" required>
                </div>

                <div class="input-name">
                <i class="fa fa-map-marker-alt lock"></i>
                    <input type="text" placeholder="Address" name="address" class="text-name" value="<?= htmlspecialchars($row['address']); ?>" required>
                </div>

                <div class="input-name">
                    <button type="submit" class="button">Update Employee</button><br>
                    <a href="manage_emp.php" class="btn">Back to Dashboard</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
