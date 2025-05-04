<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $gender = $_POST['gender'];
        // Insert employee details
    $insert = "INSERT INTO hr(name, email, company_name, address, gender) 
    VALUES('$name', '$email', '$company_name','$address', '$gender')";

    if (mysqli_query($conn, $insert)) {
        session_destroy();
        header('Location: login.php');
        exit();
    } 
    else 
    {
        $error[] = "Error: " . mysqli_error($conn);
    }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Form</title>
    <link rel="stylesheet" type="text/css" href="rstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h2>HR Form</h2>
            <?php
            if (isset($error)) 
             {
                foreach ($error as $err) 
                {
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
                <i class="fa-solid fa-building lock"></i>
                    <input type="text" placeholder="Company_name" name="company_name" class="text-name" required>
                </div>

                <div class="input-name">
                <i class="fa fa-map-marker-alt lock"></i>
                    <input type="text" placeholder="Address" name="address" class="text-name" required>
                </div>

                <div class="input-name">
                <i class="fa fa-user-tie lock"></i>
                    <input type="text" placeholder="position" name="pos" class="text-name" required>
                </div>
                <div class="input-name">
                    <input type="radio" class="radio-button" name="gender" value="Male" required>
                    <label style="margin-right: 30px;">Male</label>

                    <input type="radio" class="radio-button" name="gender" value="Female" required>
                    <label>Female</label>
                </div>


                <div class="input-name">
                    <input type="submit" name="submit" class="button" value="Submit">
                </div>
                <div class="input-name">
					<input type="checkbox" id="cb" class="check-button">
					<label for="cb" class="check">I have already fiiled this form <a href="login.php"> Login</a></label>
				</div>
        </div>
        </div>
        </body>
</html>