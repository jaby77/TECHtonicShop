<?php
	session_start();
	include 'connect.php';
	

	if($_SERVER["REQUEST_METHOD"]==="POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM tbl_login WHERE username = '".$username."' AND password = '".$password."' ";

		$result = mysqli_query($con, $sql);

		$row = mysqli_fetch_array($result);

		if($row["usertype"]=="user") {
			header('location:load-product.php');
		}
		if($row["usertype"]=="admin") {
			header('location:admin/index.html');
		}
		else{
			echo "<script> alert('Wrong username or password'); window.location.href = 'login.php'; </script>";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Font Awesome -->
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
			max-width: 420px;
			background: #fff;
			border: none;
			border-radius: 20px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
			padding: 30px;
			animation: fadeIn 0.6s ease-in-out;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.card h2 {
			color: #c43737;
			font-weight: 700;
			text-align: center;
			margin-bottom: 25px;
			text-transform: uppercase;
		}

		.card .form-label {
			font-weight: 600;
			letter-spacing: 1px;
		}

		.card .form-control {
			border-radius: 10px;
			border: 1px solid #ccc;
		}

		.card .form-control:focus {
			border-color: #c43737;
			box-shadow: 0 0 0 0.2rem rgba(196, 55, 55, 0.25);
		}

		.btn-custom {
			background-color: #c43737;
			color: white;
			border-radius: 10px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.btn-custom:hover {
			background-color: #a42e2e;
		}

		.register-link {
			display: block;
			text-align: center;
			margin-top: 15px;
			color: #c43737;
			font-weight: 500;
		}

		.register-link:hover {
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
		<form method="post" action="">
			<h2>Login</h2>

			<div class="icon-wrapper">
				<i class="fas fa-user-circle"></i>
			</div>

			<div class="form-group">
				<label class="form-label"><i class="fas fa-user"></i> Username</label>
				<input type="text" name="username" class="form-control" placeholder="Enter username" required>
			</div>

			<div class="form-group">
				<label class="form-label"><i class="fas fa-lock"></i> Password</label>
				<input type="password" name="password" class="form-control" placeholder="Enter password" required>
			</div>

			<button type="submit" class="btn btn-custom btn-block">
				Login <i class="fas fa-sign-in-alt ml-2"></i>
			</button>

			<a href="register.php" class="register-link"><i class="fas fa-user-plus"></i> Don’t have an account? Register here</a>
		</form>
	</div>

	<!-- JS (Optional for Bootstrap Features) -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
