<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';


$oglasi = "SELECT * FROM oglasi";
$result = $conn->query($oglasi) or die ("Bad query: #sql");

if(isset($_GET['delete']))
{
  $id = $_GET['delete'];
  $conn->query("DELETE FROM oglasi WHERE id=$id") or die($conn->error());

  $page = $_SERVER['PHP_SELF'];
  $sec = "0.1";
}

if(isset($_GET['udomljeni']))
{
  $id = $_GET['udomljeni'];
  $oglasi = "INSERT INTO udomljeni SELECT * FROM oglasi WHERE id=$id; DELETE FROM oglasi WHERE id=$id";
  $result = $conn->query($oglasi) or die ("Bad query: #sql");

  $page = $_SERVER['PHP_SELF'];
  $sec = "0.1";
}

$slike = "SELECT * FROM slike";
$slik = $conn->query($slike) or die ("Bad query: #sql");

if(!isset($_SESSION['username'])){
  header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Moji oglasi</title>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
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

  #oglasmob {
    display: flex;
    margin: 10px;
  }
</style>
<?php 
include 'header.php';
?>

<div class="container pt-4">
<div class="text-center text-white">
  <h2>Moji oglasi</h2>
</div>
<div class="row d-flex justify-content-center">
  <?php while($row = $result->fetch(PDO::FETCH_ASSOC))  { ?>
  <?php if($row['korisnicko_ime'] == $_SESSION['username']){ ?>
    <div class="" id="oglasmob">
        <div class="card mb-3 box-shadow" style="width: 14rem;">
          <?php echo "<img class='card-img-top' style='object-fit: cover;' height='150' src='".$row['image']."'>"; ?>
          <div class="card" style="padding: 10px;">
          <p class="card-title" style="font-weight: bold;"><?php echo $row["ime"]; ?></p>
          <small class="card-text"><?php echo substr($row["opis"], 0, 40)?></small>
          <div class="d-flex justify-content-between align-items-center pt-3">
              <small class="text-muted"><i class="fa fa-map-marker pr-1" aria-hidden="true"></i><?php echo $row["lokacija"]; ?></small>
          </div>
          <div class="mt-2">
              <small>Objavljeno <?php echo $row["date"]; ?></small>
          </div>
          <div class="btn-group">
            <a class="btn btn-sm btn-outline-secondary" href="view.php?id=<?php echo $row["id"]; ?>">Oglas</a>
            <a href="edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-success">Uredi</a>
            <a href="myoglas.php?delete=<?php echo $row["id"]; ?>" class="btn btn-sm btn-danger">Obriši</a>
          </div>
          <div class="btn-group">
          <a href="myoglas.php?udomljeni=<?php echo $row["id"]; ?>" class="btn btn-sm btn-info">Udomljen/na</a>
          </div>
        </div>
        </div>
    </div>
  <?php } ?>
  <?php } ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>