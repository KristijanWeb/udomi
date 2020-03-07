<?php
require_once '../all/config/db_connect.php';

$id = $_GET['id'];

$oglasi = "SELECT * FROM oglasi WHERE id=$id";
$result = $conn->query($oglasi) or die ("Bad query: #sql");

$slike = "SELECT * FROM slike";
$slik = $conn->query($slike) or die ("Bad query: #sql");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<style>
  body {
    min-height: 100vh;
    background:linear-gradient(0deg, rgba(120, 124, 128, 0.6), rgba(120, 124, 128, 0.6)), url('../login/img/ttt.jpg');
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>

<div class="p-1" style="background-color: white; margin: 0; min-width: 100%;">
<div class="container">
  <div class="d-flex align-items-center justify-content-between">
    <div>
        <a class="navbar-brand" href="../index.php"><img src="../all/img/homepets.png" height="50" alt="Slika...."></a>
    </div>
    <div class="d-flex">
        <ul class="navbar-nav">
            <li class="nav-item mr-3"><a class="btn" style="background-color: #ce84a7; color: white;" href="../login.php">Prijavi se</a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="btn" style="background-color: #d6bb82; color: white;" href="../signup.php">Registriraj se</a></li>
        </ul>
    </div>
  </div>
</div>
</div>

<div class="container">
    <?php while($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="text-center p-4">
        <h2 class="text-white"><?php echo $row['ime']; ?></h2>
    </div>
    <hr style="background-color: #fff;" />
    <dl class="row detaljiimena" style="background-color: #0e335699; border-radius: 10px; color: #fff; padding: 2rem;">
        <dt class="col-sm-2">
            Ime
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['ime']; ?>
        </dd>
        <dt class="col-sm-2">
            Dob
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['godine']; ?>
        </dd>
        <dt class="col-sm-2">
            Spol
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['spol']; ?>
        </dd>
        <dt class="col-sm-2">
            Cjepljen protiv bjesnoće
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['bjesnoca']; ?>
        </dd>
        <dt class="col-sm-2">
            Cjepljen protiv zaraznih bolesti
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['zaraznebolesti']; ?>
        </dd>
        <dt class="col-sm-2">
            Čipiran
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['cip']; ?>
        </dd>
        <dt class="col-sm-2">
            Naučen na život u stanu
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['zivotustanu']; ?>
        </dd>
        <dt class="col-sm-2">
            Naučen na druge životinje
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['drugezivotinje']; ?>
        </dd>
        <dt class="col-sm-2">
            Sterilizirana/Kastriran
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['steriliziran']; ?>
        </dd>
        <dt class="col-sm-2">
            Opis
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['opis']; ?>
        </dd>
        <dt class="col-sm-2">
            Lokacija
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['lokacija']; ?>
        </dd>
        <dt class="col-sm-2">
            Kontakt
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['kontakt']; ?>
        </dd>
        <dt class="col-sm-2">
            Oglas objavio
        </dt>
        <dd class="col-sm-10">
            <?php echo $row['ime_i_prezime']; ?>
        </dd>
        <dt class="col-sm-2">
            Slika
        </dt>
        <dd class="col-sm-10">
        <?php while($pic = $slik->fetch(PDO::FETCH_ASSOC)) { ?>
        <?php if($row['korisnicko_ime'] == $pic['userid'] && $row['vrijeme'] == $pic['vrijeme']){ ?>
            <img style="height: 200px; margin: 5px;" style="cursor: zoom-in"  class="img-thumbnail" src="../all/<?php echo $pic['image']; ?>">
        <?php } ?>
        <?php } ?>
        </dd>
        <div class="d-flex justify-content-between" style="width: 100%;">
            <a href="oglasall.php" class="btn btn-info">Nazad na oglase</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank" class="btn btn-secondary">Podjeli na Facebook</a>
        </div>
    </dl>
    <?php } ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>