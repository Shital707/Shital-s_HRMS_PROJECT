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

// Fetch employee details securely
$sql = "SELECT name, email, department, position, address, gender FROM employees WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $emp_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $emp = $result->fetch_assoc();
} else {
    echo "Employee profile not found!";
    exit();
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="profile-container">
        <div class="profile-box">
            
            <!-- Profile Image Section -->
            <div class="profile-img">
                <img src="profile.png" alt="Profile Picture">
            </div>

            <!-- Employee Name -->
            <div class="profile-name">
                <h1><?php echo htmlspecialchars($emp['name']); ?></h1>
            </div>

            <!-- Profile Details Section -->
            <div class="profile-info">
                <div class="info-item"><strong>Email:</strong> <span><?php echo htmlspecialchars($emp['email']); ?></span></div>
                <div class="info-item"><strong>Department:</strong> <span><?php echo htmlspecialchars($emp['department']); ?></span></div>
                <div class="info-item"><strong>Position:</strong> <span><?php echo htmlspecialchars($emp['position']); ?></span></div>
                <div class="info-item"><strong>Address:</strong> <span><?php echo htmlspecialchars($emp['address']); ?></span></div>
                <div class="info-item"><strong>Gender:</strong> <span><?php echo htmlspecialchars($emp['gender']); ?></span></div>
            </div>

            <!-- Button Section -->
            <div class="btn-container">
                <a href="emp_dashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>

        </div>
    </div>
</body>
</html>
