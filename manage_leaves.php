<?php
session_start();
@include 'config.php';
$hr_name = $_SESSION['user_name'] ?? null;
if (!$hr_name) 
{
    echo "<script>alert('Access Denied. Please log in.'); window.location.href='login.php';</script>";
    exit();
}
$sql = "SELECT * FROM leaves ORDER BY id DESC";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_id = $_POST['leave_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE leaves SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $leave_id);

    if ($stmt->execute()) 
    {
        echo "<script>alert('Leave status updated successfully!'); window.location.href='manage_leaves.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Leave Requests</title>
    <link rel="stylesheet" href="leave_manage.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="leave-container">
        <h1>Manage Leave Requests</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['emp_id']; ?></td>
                <td><?= $row['leave_type']; ?></td>
                <td><?= $row['start_date']; ?></td>
                <td><?= $row['end_date']; ?></td>
                <td><?= $row['reason']; ?></td>
                <td><?= $row['status']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="leave_id" value="<?= $row['id']; ?>">
                        <select name="status">
                            <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Approved" <?= ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                            <option value="Rejected" <?= ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="hr_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
