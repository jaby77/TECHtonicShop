<?php

	include 'connect.php';

	if($_SERVER["REQUEST_METHOD"]==="POST") {
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];
		$cpassword = $_REQUEST['cpassword'];


		if($password!=$cpassword){
			echo "<script> alert('Password does not match!'); window.location.href = 'register.php'; </script>";
		}
		else{
			$sql = "INSERT INTO  tbl_login (username, password) VALUES ('$username', '$password')";
			$result = mysqli_query($con, $sql);
			echo "<script> alert('Successfully Registerd!'); window.location.href = 'login.php'; </script>";
		}
	
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register Page</title>

	<!-- Bootstrap & Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">

	<style>
		body {
			background: linear-gradient(to bottom right, #c43737, #a42e2e);
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		.card {
			width: 100%;
			max-width: 460px;
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
			padding: 30px;
			animation: fadeIn 0.5s ease-in-out;
		}

		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(20px); }
			to { opacity: 1; transform: translateY(0); }
		}

		h2 {
			color: #c43737;
			font-weight: 700;
			text-align: center;
			margin-bottom: 25px;
			text-transform: uppercase;
		}

		label {
			font-weight: 600;
			color: #333;
			letter-spacing: 1px;
		}

		.form-control {
			border-radius: 10px;
			border: 1px solid #ccc;
		}

		.form-control:focus {
			border-color: #c43737;
			box-shadow: 0 0 0 0.2rem rgba(196, 55, 55, 0.25);
		}

		.btn-custom {
			background-color: #c43737;
			color: white;
			border-radius: 10px;
			font-weight: 600;
			transition: 0.3s;
		}

		.btn-custom:hover {
			background-color: #a42e2e;
		}

		.link {
			color: #c43737;
			font-weight: 500;
			display: block;
			text-align: center;
			margin-top: 15px;
		}

		.link:hover {
			text-decoration: underline;
		}

		.icon-wrapper {
			text-align: center;
			margin-bottom: 20px;
		}

		.icon-wrapper i {
			font-size: 80px;
			color: #c43737;
		}
	</style>
</head>
<body>

	<div class="card">
		<form method="post" action="#">
			<h2>Register</h2>

			<div class="icon-wrapper">
				<i class="fas fa-user-circle"></i>
			</div>

			<div class="form-group">
				<label><i class="fas fa-user"></i> Username</label>
				<input type="text" name="username" class="form-control" placeholder="Enter username" required>
			</div>

			<div class="form-group">
				<label><i class="fas fa-lock"></i> Password</label>
				<input type="password" name="password" class="form-control" placeholder="Enter password" required>
			</div>

			<div class="form-group">
				<label><i class="fas fa-lock"></i> Confirm Password</label>
				<input type="password" name="cpassword" class="form-control" placeholder="Confirm password" required>
			</div>

			<button type="submit" class="btn btn-custom btn-block">
				<i class="fas fa-user-plus"></i> Register
			</button>

			<a href="login.php" class="link"><i class="fas fa-sign-in-alt"></i> Already have an account? Login here</a>
		</form>
	</div>

	<!-- Optional Bootstrap Scripts -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
