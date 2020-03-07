<?php
include_once 'config/db_connect.php';
require_once 'config/session.php';

$lista = "SELECT * FROM users";
$list = $conn->query($lista) or die ("Bad query: #sql");

if(!isset($_SESSION['username'])){
    header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<?php 
include 'header.php';
?>

<style>
body {
    min-height: 100vh;
    background:linear-gradient(0deg, rgba(120, 124, 128, 0.6), rgba(120, 124, 128, 0.6)), url('../login/img/ttt.jpg');
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>

<div class="container pt-5">
    <div>
        <h2 class="text-white">Informacije o korisniku</h2>
    </div>
    <div>
    <?php
    if(isset($_GET['msg'])) { 
    ?>
        <div class="alert alert-success"><?php echo $_GET['msg']; ?></div>
    <?php 
    }
    ?>
    </div>
    <img style="margin-bottom: -30px;" src="img/slika.png" height="100" alt="user...">
<dl class="row detaljiimena" style="background-color: #0e335699; border-radius: 10px; color: #fff; padding: 2rem;">
<?php while($row = $list->fetch(PDO::FETCH_ASSOC)) { ?>
<?php if($row['username'] == $_SESSION['username']) { ?>
    <dt class="col-sm-2">
        Ime
    </dt>
    <dd class="col-sm-10">
        <?php echo $row['ime']; ?>
    </dd>
    <dt class="col-sm-2">
        Prezime
    </dt>
    <dd class="col-sm-10">
        <?php echo $row['prezime']; ?>
    </dd>
    <dt class="col-sm-2">
        Korisničko ime
    </dt>
    <dd class="col-sm-10">
        <?php echo $row['username']; ?>
    </dd>
    <dt class="col-sm-2">
        Email
    </dt>
    <dd class="col-sm-10">
        <?php echo $row['email']; ?>
    </dd>
    <dt class="col-sm-2">
        Kontakt
    </dt>
    <dd class="col-sm-10">
        0<?php echo $row['mobitel']; ?>
    </dd>
    <div class="p-3">
        <a href="useredit.php?id=<?php echo $row["Id"]; ?>" class="btn btn-sm btn-info">Izmjeni podatke</a>
    </div>
<?php } ?>
<?php } ?>
</dl>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>