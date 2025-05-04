<?php
session_start();
include 'config.php';

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-msg">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Clear message after displaying
}
// Fetch employees from the database
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <link rel="stylesheet" href="manage_empstyle.css">
</head>
<body>
<div class="blurred-background">
</div>
<div class="container ">
    <h1 class="mb">Employee Management</h1>
    <a href="add_emp.php" class="btn btn1 ">Add Employee</a>
    <a href="logout.php" class="btn btn2">Logout</a>
    <a href="hr_dashboard.php" class="btn btn1 ">Back to Dashboard</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Work</th>
                <th>Position</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['work']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <a href="edit_emp.php?id=<?php echo $row['id']; ?>" class="btn btn3">Edit</a>
                        <a href="delete_emp.php?id=<?php echo $row['id']; ?>" class="btn btn4" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
