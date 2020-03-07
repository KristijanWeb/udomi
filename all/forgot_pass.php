<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

$msg = "";

if(isset($_POST['sendemail']))
{
	$email = $_POST['emailreset'];
	
	$s = "SELECT * FROM users WHERE email='{$email}'";
	$ss = $conn->query($s) or die ("Bad query: #sql");
	$data = $ss->fetch();

	if($data > 0)
	{
        $newpass = "Pa24ss.@wklord!!";
		$hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
		
		$sql = "UPDATE users SET password='{$hashed_password}' WHERE email='{$email}'";
		$userr = $conn->prepare($sql);
    	$userr->execute();

		if($userr)
		{
			require 'src/PHPMailer.php';
			require 'src/SMTP.php';
			require 'src/Exception.php';

			$mail = new PHPMailer\PHPMailer\PHPMailer();
																
			$mail->Host       = 'smtp.example.com';                    
			$mail->SMTPAuth   = true;                                   
			$mail->Username   = 'hrabrenjuskeudomi@gmail.com';                     
			$mail->Password   = '12345';                               
			$mail->SMTPSecure = "tls";         
			$mail->Port       = 587;                                  

			//Recipients
			$mail->setFrom('hrabrenjuskeudomi@gmail.com');
			$mail->addAddress($_POST['emailreset']);              
			$mail->addReplyTo($_POST['emailreset']);

			// Content
			$mail->isHTML(true);                                  
			$mail->Subject = 'Zahtjev za novu lozinku!';
			$mail->Body    = 'Pozdrav, <br><br> Vaša nova lozinka je: '. $newpass .'<br><br><strong>Obavezno promjenite lozinku nakon ove prijave!</strong>';

			if(!$mail->send())
			{
				$msg = "<div class='alert alert-danger' role='alert'>Neuspješno.</div>";
			}
			else {
				$msg = "<div class='alert alert-success' role='alert'>Uspješno poslano.</div>";
			}
		}
        
	}
	else {
		$msg = "<div class='alert alert-danger' role='alert'>Nije poslano.</div>";
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
	<link rel="stylesheet" type="text/css" href="../login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login/css/util.css">
	<link rel="stylesheet" type="text/css" href="../login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
<div class="limiter">
<div class="container-login100">
	<div class="wrap-login100" style="padding: 50px !important">
		<div class="login100-pic js-tilt" data-tilt>
			<img src="../login/img/efefe.png" alt="IMG">
		</div>
		<form class="login100-form validate-form" action="forgot_pass.php" method="post">
			<span class="text-center d-flex p-2" style="font-weight: bold;">
				Upisi svoj email kako bi poslali ponovo postavljanje lozinke!
			</span>
			<div class="text-center p-2">
			<?php 
				echo $msg;
			?>
			</div>
			<div class="wrap-input100 validate-input" data-validate = "Password is required">
				<input class="input100" type="text" name="emailreset" placeholder="Email">
				<span class="focus-input100"></span>
				<span class="symbol-input100">
					<i class="fa fa-envelope" aria-hidden="true"></i>
				</span>
            </div>

			<div class="container-login100-form-btn">
				<input style="cursor: pointer;" class="login100-form-btn" type="submit" name="sendemail" class="btn" value="Pošalji">
			</div>
			<div class="container-login100-form-btn">
				<a href="../index.php" class="btn btn-info">Odustani</a>
			</div>
		</form>
	</div>
</div>
</div>
	
<!--===============================================================================================-->	
	<script src="../login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../login/vendor/bootstrap/js/popper.js"></script>
	<script src="../login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>