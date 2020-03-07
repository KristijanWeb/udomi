<?php
require_once './all/config/db_connect.php';
require_once './all/config/session.php';

if(isset($_POST['login-btn'])) {
	if(empty($_POST['username']) || empty($_POST['userpass']))
	{
		$ms = 'Korisničko ime i lozinka nisu ispunjeni!';
		header('location: login.php?ms='.$ms);
	}
}

if(isset($_POST['login-btn'])) {
    $user = $_POST['username'];
    $password = $_POST['userpass'];

    $SQLQuery = "SELECT * FROM users WHERE username = :username";
    $statement = $conn->prepare($SQLQuery);
    $statement->execute(array(':username' => $user));

    while($row = $statement->fetch()) {
      $id = $row['id'];
      $hashed_password = $row['password'];
      $username = $row['username'];
      
      if(password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $id;
		$_SESSION['username'] = $username;
        header('location: ./all/dashboard.php');
      }
      else {
		$msg = "Korisničko ime ili lozinka nisu točni!";
        header('location: login.php?msg='.$msg);
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
<div class="limiter">
<div class="container-login100">
	<div class="wrap-login100">
		<div class="login100-pic js-tilt" data-tilt>
			<img src="login/img/efefe.png" alt="IMG">
		</div>
		<form class="login100-form validate-form" action="login.php" method="post">
			<span class="login100-form-title">
				Prijavi se
			</span>
			<div class="text-center" style="
				color: red;
				margin: 20px;
				font-size: 13px;">
				<?php
				if(isset($_GET['msg'])) echo $_GET['msg'];
				?>
			</div>
			<div class="text-center" style="
				color: red;
				margin: 20px;
				font-size: 13px;">
				<?php
				if(isset($_GET['ms'])) echo $_GET['ms'];
				?>
			</div>

			<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
				<input class="input100" type="text" name="username" placeholder="Korisničko ime">
				<span class="focus-input100"></span>
				<span class="symbol-input100">
					<i class="fa fa-envelope" aria-hidden="true"></i>
				</span>
			</div>
			<div class="wrap-input100 validate-input" data-validate = "Password is required">
				<input class="input100" type="password" name="userpass" placeholder="Password">
				<span class="focus-input100"></span>
				<span class="symbol-input100">
					<i class="fa fa-lock" aria-hidden="true"></i>
				</span>
			</div>
			<div class="container-login100-form-btn">
				<input style="cursor: pointer;" class="login100-form-btn" type="submit" name="login-btn" class="btn" value="Prijava">
			</div>
			<div class="text-center p-t-12">
				<span class="txt1">Zaboravljena</span>
				<a class="txt2" href="./all/forgot_pass.php">Lozinka?</a>
			</div>
			<div class="mt-4 text-center">
				<a href="index.php" class="btn btn-secondary">Odustani</a>
			</div>

			<div class="text-center p-t-136">
				<a class="font-weight-bold" href="signup.php">
					Registriraj se
					<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
				</a>
			</div>
		</form>
	</div>
</div>
</div>
	
<!--===============================================================================================-->	
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>