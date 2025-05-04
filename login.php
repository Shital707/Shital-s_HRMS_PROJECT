<?php 
@include 'config.php';
session_start();

if (isset($_POST['submit'])) { 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = md5($_POST['password']); 

    $select = "SELECT * FROM users WHERE name='$name'";
    $result = mysqli_query($conn, $select);

    // Check if query execution failed
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn)); // Show SQL error
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        
        if ($row['password'] == $pass) { // Ensure password matches
            if ($row['user_type'] == 'HR') {
                $_SESSION['admin_name'] = $row['name'];
                header('Location: hr_dashboard.php');
                exit;  // Stop script execution
            } elseif ($row['user_type'] == 'Employee') {
                $_SESSION['user_name'] = $row['name'];
                header('Location: emp_dashboard.php');
                exit;
            }
        } else {
            $error[] = "Incorrect username or password!";
        }
    } else {
        $error[] = "Incorrect username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="login_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="blurred-background">
    </div>
	<div class="container">
		<!-- login form -->
		<div class="form-card">
			<h2>Login</h2>
			<!-- balloon animation -->
			<div class="balloon-container">
				<div class="balloon"></div>
				<div class="balloon"></div>
				<div class="balloon"></div>
			</div>
			<form method="POST">
				<div class="input-group">
					<input type="text" name="name" placeholder="Username" required>
					<i class="fa fa-user lock"></i>
				</div>
				<div class="input-group">
					<input type="password" name="password" placeholder="Password" required>
					<i class="fa fa-lock"></i>
				</div>
				<button type="submit" name="submit">LOGIN</button></br></br>
				<p>Not registered? <a href="registration.php"> Register</a></p>
				<?php
				if (!empty($error)) {
					foreach ($error as $err) {
						echo "<div class='error-message'>$err</div>";
					}
				}
				?>
			</form>
		</div>
	</div>
</body>
</html>
