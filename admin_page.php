<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name']))
{
    header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- custom css file link -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h2> Hii!, <span>HR</span></h2></br>
            <h2> Welcome <span> <?php echo $_SESSION['admin_name'] ?></span></h2></br>
            <p> this is the HR(admin) page</p>
            <a href="login_form.php" class="btn">Login</a>
            <a href="registration.php" class="btn">Register</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>