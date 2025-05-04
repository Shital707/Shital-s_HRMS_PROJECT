<?php
    $conn=mysqli_connect('localhost','root','','hrms1');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>