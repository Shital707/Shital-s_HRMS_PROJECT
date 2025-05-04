<?php
session_start();
@include 'config.php';

// Ensure the HR is logged in
if (!isset($_SESSION['admin_name'])) {
    echo "Access Denied! Please log in first.";
    exit();
}

$hr_name = $_SESSION['admin_name']; // Get HR name from session

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch HR details securely using admin_name
$sql = "SELECT name, email, company_name, address, gender FROM hr WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hr_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hr = $result->fetch_assoc();
} else {
    echo "HR profile not found!";
    exit();
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Profile</title>
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

            <!-- HR Name -->
            <div class="profile-name">
                <h1><?php echo htmlspecialchars($hr['name']); ?></h1>
            </div>

            <!-- Profile Details Section -->
            <div class="profile-info">
                <div class="info-item"><strong>Email:</strong> <span><?php echo htmlspecialchars($hr['email']); ?></span></div>
                <div class="info-item"><strong>Company:</strong> <span><?php echo htmlspecialchars($hr['company_name']); ?></span></div>
                <div class="info-item"><strong>Address:</strong> <span><?php echo htmlspecialchars($hr['address']); ?></span></div>
                <div class="info-item"><strong>Gender:</strong> <span><?php echo htmlspecialchars($hr['gender']); ?></span></div>
            </div>

            <!-- Button Section -->
            <div class="btn-container">
                <a href="hr_dashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>

        </div>
    </div>

</body>
</html>

