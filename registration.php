<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $gender = $_POST['gender'];
    $user_type = $_POST['user_type'];

    // Check if user already exists
    $select = "SELECT * FROM users WHERE name='$name'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error = 'User already exists!';
    } else {
        if ($pass !== $cpass) {
            $error = 'Passwords do not match!';
        } else {
            // Insert data into the database
            $insert = "INSERT INTO users(name, email, password, gender, user_type) 
                       VALUES('$name', '$email', '$pass', '$gender', '$user_type')";
            if (mysqli_query($conn, $insert)) {
                if ($user_type == 'HR') {
                    header("Location: hr_details.php");
                } else {
                    header('Location: emp_form.php');
                }
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Registration Form</title>
    <link rel="stylesheet" type="text/css" href="rstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <div class="blurred-background">
    </div>
    <div class="container">
        <form action="" method="POST">
            <h2>Registration Form</h2>
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
                    <i class="fa fa-lock lock"></i>
                    <input type="password" placeholder="Password" name="password" class="text-name" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-lock lock"></i>
                    <input type="password" placeholder="Confirm Password" name="cpassword" class="text-name" required>
                </div>

                <div class="input-name">
                    <input type="radio" class="radio-button" name="gender" value="Male" required>
                    <label style="margin-right: 30px;">Male</label>

                    <input type="radio" class="radio-button" name="gender" value="Female" required>
                    <label>Female</label>
                </div>

                <div class="input-name">
                    <select name="user_type" class="Role" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="HR">HR</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>

                <div class="input-name">
                    <input type="submit" name="submit" class="button" value="Register">
                </div>
                <div class="input-name">
					<input type="checkbox" id="cb" class="check-button">
					<label for="cb" class="check">I have already registered <a href="login.php"> Login</a></label>
				</div>
        </div>
        </div>
        </body>
</html>