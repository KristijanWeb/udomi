<?php
require_once './all/config/db_connect.php';
require_once './all/config/session.php';

if(isset($_POST['signup-btn'])) {
  $ime = $_POST['ime'];
  $prezime = $_POST['prezime'];
  $mob = $_POST['mobitel'];
  $username = $_POST['username'];
  $email = $_POST['useremail'];
  $password = $_POST['userpass'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $SQLInsert1 = "SELECT * FROM users WHERE username='$username' or email = '$email'";
  $run = $conn->prepare($SQLInsert1);
  $run->execute();
  
  if($run->rowCount() > 0){
    $msg = "Korisničko ime ili email je zauzeto, pokušajte ponovo!";
    header('location: signup.php?msg='.$msg);
  }
  else{
    $SQLInsert = "INSERT INTO users (username, password, email, mobitel, prezime, ime ,to_date) 
                VALUES (:username, :password, :email, :mobitel, :prezime, :ime, now())";
    $statement = $conn->prepare($SQLInsert);
    $statement->execute(array(':username' => $username, ':password' => $hashed_password, ':email' => $email, ':mobitel' => $mob, ':prezime' => $prezime, ':ime' => $ime));

    if($statement->rowCount() == 1) {
      header('location: login.php');
    }
  }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>SignUp</title>
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
					<img src="login/img/efefe.png" alt="IMG">
				</div>
                
				<form class="login100-form validate-form" action="signup.php" method="post" enctype="multipart/form-data">
					<span class="login100-form-title">
						Otvori svoj račun
					</span>
					<div style="
						color: red;
						margin: 20px;
						font-size: 13px;">
					<?php
					if(isset($_GET['msg'])) echo $_GET['msg'];
					?>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="ime" placeholder="Ime" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="prezime" placeholder="Prezime" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>
                    <div class="wrap-input100 validate-input">
						<input class="input100" type="number" name="mobitel" placeholder="Mobitel" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-mobile" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" placeholder="Korisničko ime" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>
                    <div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="useremail" placeholder="Email" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="userpass" placeholder="Lozinka" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input style="cursor: pointer;" class="login100-form-btn" type="submit" name="signup-btn" class="btn" value="Registriraj se">
						<div class="mt-4">
							<a href="index.php" class="btn btn-secondary">Odustani</a>
						</div>
					</div>

					<div class="text-center p-t-90">
						<a class="txt2" href="login.php">
							Prijavi se
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