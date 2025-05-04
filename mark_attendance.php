<?php
session_start();
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date("Y-m-d"); // Today's date
    $status = $_POST['status'];

    // Check if attendance already marked for today
    $check = $conn->query("SELECT * FROM attendance WHERE e_id='$e_id' AND date='$date'");
    if ($check->num_rows > 0) {
        echo "<p style='color: red;'>Attendance already marked for today!</p>";
    } else {
        // Insert attendance
        $sql = "INSERT INTO attendance (e_id, date, status) VALUES ('$e_id', '$date', '$status')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Attendance marked successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
</head>
<body>
    <h2>Mark Your Attendance</h2>
    <form method="POST">
        <label>Select Status:</label>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select><br><br>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>
