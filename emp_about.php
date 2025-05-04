<?php
session_start();
@include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About HRMS</title>
    <style>
        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size:35px
            margin: 20px;
            padding: 20px;
        }
        .blurred-background {
            background: url('work-team-digital-art.jpg') center/cover no-repeat;
            filter: blur(2px);
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .content {
            position: relative;
            z-index: 1;
            padding: 10px;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: rgba(224, 217, 225, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }
        h2 {
            text-align: center;
            color: rgb(78, 3, 71);
            font-size:30px
        }
        .btn-back {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background:rgb(78, 3, 71);
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background:rgb(227, 140, 230);
        }
    </style>
</head>
<body>
<div class="blurred-background">
</div>
<div class="container">
    <h2>About Human Resource Management System</h2>
    <p>
        Welcome to the <b>Human Resource Management System (HRMS)</b>. This system is designed to help HR managers and employees manage key HR tasks efficiently. It includes:
    </p>
    <ul>
        <li>Profile of Employee </li>
        <li>Apply for Leaves</li>
        <li>Check Salary</li>
        <li>Secure Authentication and Access Control</li>
    </ul>
    <p>
        This system ensures a smooth workflow between HR and employees, improving communication and efficiency in managing human resources.
    </p>
    <a href="emp_dashboard.php" class="btn-back">Back to Dashboard</a>
</div>
</body>
</html>
