<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $work = mysqli_real_escape_string($conn, $_POST['work']);
    $pos = mysqli_real_escape_string($conn, $_POST['pos']);
    $gender = $_POST['gender'];
    $addr = mysqli_real_escape_string($conn, $_POST['addr']);

    // Insert employee details
    $insert = "INSERT INTO employees(name, email, department, work, position, gender, address) 
               VALUES('$name', '$email', '$dept','$work','$pos', '$gender', '$addr')";

    if (mysqli_query($conn, $insert)) {
        $_SESSION['success_message'] = "Employee added successfully!";
        header('Location: manage_emp.php'); // Redirect to manage employee page
        exit();
    } else {
        $error[] = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" type="text/css" href="rstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<div class="blurred-background">
</div>
    <div class="container">
        <form action="" method="POST">
            <h2>Add Employee</h2>

            <!-- Display Error Messages -->
            <?php
            if (!empty($error)) {
                foreach ($error as $err) {
                    echo '<span class="error-msg">' . $err . '</span>';
                }
            }
            ?>

            <div class="form-container">
                <div class="input-name">
                    <i class="fa fa-user lock"></i>
                    <input type="text" placeholder="Full Name" name="name" class="name" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-envelope lock"></i>
                    <input type="email" placeholder="Email" name="email" class="text-name" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-building lock"></i>
                    <input type="text" placeholder="Department" name="dept" class="text-name" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-briefcase lock"></i>
                    <input type="text" placeholder="Work" name="work" class="text-name" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-user-tie lock"></i>
                    <input type="text" placeholder="Position" name="pos" class="text-name" required>
                </div>

                <div class="input-name">
                    <input type="radio" class="radio-button" name="gender" value="Male" required>
                    <label style="margin-right: 30px;">Male</label>

                    <input type="radio" class="radio-button" name="gender" value="Female" required>
                    <label>Female</label>
                </div>

                <div class="input-name">
                    <i class="fa fa-map-marker-alt lock"></i>
                    <input type="text" placeholder="Address" name="addr" class="text-name" required>
                </div>

                <div class="input-name">
                    <input type="submit" name="submit" class="button" value="Add Employee">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
