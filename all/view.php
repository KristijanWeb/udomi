<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $oglasi = "SELECT * FROM oglasi WHERE id=$id";
    $result = $conn->query($oglasi) or die ("Bad query: #sql");
}

$slike = "SELECT * FROM slike";
$slik = $conn->query($slike) or die ("Bad query: #sql");

if(isset($_POST['send']))
{
    $poruku_salje = $_POST['user_salje'];
    $poruku_prima = $_POST['user_prima'];
    $poruka = $_POST['poruka'];
    $vrijeme = date('H:i');

    $q = "INSERT INTO message (user_salje, user_prima, poruka, date) VALUES (:user_salje, :user_prima, :poruka, :date)";
    $qq = $conn->prepare($q);
    $qq->execute(array(':user_salje' => $poruku_salje, ':user_prima' => $poruku_prima, ':poruka' => $poruka, ':date' => $vrijeme));

    header("Location: inbox.php?user=$poruku_prima");
}

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
    <title>Oglas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
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
<?php 
include 'header.php';
?>

<div class="container">
    <?php while($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="text-center p-4">
        <h2 class="text-white"><?php echo $row['ime']; ?></h2>
    </div>
    <hr style="background-color: #fff;" />
    <dl class="row detaljiimena" style="background-color: #0e335699; border-radius: 10px; color: #fff; padding: 2rem;">
        <?php if($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'hrabre.njuske'){ ?>
            <dt class="col-sm-2">
                Korisnicko ime
            </dt>
            <dd class="col-sm-10">
                <?php echo $row['korisnicko_ime']; ?>
            </dd>
        <?php }?>
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
        <dd class="col-sm-10 popup">
        <?php while($pic = $slik->fetch(PDO::FETCH_ASSOC)) { ?>
        <?php if($row['korisnicko_ime'] == $pic['userid'] && $row['vrijeme'] == $pic['vrijeme']){ ?>
            <img style="height: 200px; margin: 5px;" style="cursor: zoom-in"  class="img-thumbnail" src="<?php echo $pic['image']; ?>">
        <?php } ?>
        <?php } ?>
        </dd>
        <div class="d-flex justify-content-between" style="width: 100%;">
            <a href="dashboard.php" class="btn btn-info">Nazad na oglase</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank" class="btn btn-secondary">Podjeli na Facebook</a>
            <?php if($row['korisnicko_ime'] != $_SESSION['username']){ ?>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">Pošalji poruku</a>
            <?php } ?>
            <?php if($_SESSION['username'] == "admin" || $_SESSION['username'] == "hrabre.njuske" || $row['korisnicko_ime'] == $_SESSION['username']){ ?>
            <a href="dashboard.php?delete=<?php echo $row["id"]; ?>" class="btn btn-danger">Obriši</a>
            <?php } ?>
        </div>
    </dl>
</div>

<div class="openmess" id="open">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Posalji poruku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="view.php" method="post">
            <div class="form-group col" style="display: none;">
                <label>Poruku šalje</label>
                <input type="text" name="user_salje" class="form-control" value="<?php echo $_SESSION['username'] ?>" required>
            </div>
            <div class="form-group col" style="display: none;">
                <label>Poruku prima</label>
                <input type="text" name="user_prima" value="<?php echo $row['korisnicko_ime']; ?>" class="form-control" required>
            </div>
            <div class="form-group col">
                <label>Poruka</label>
                <textarea name="poruka" class="form-control" placeholder="Napiši poruku" cols="20" rows="10" required></textarea>
            </div>
            <div class="modal-footer">
                <input type="submit" name="send" class="btn btn-primary" value="Pošalji">
            </div>
        </form>
      <?php } ?>
      </div>
    </div>
  </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>