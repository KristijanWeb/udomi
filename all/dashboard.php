<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

$limit = 12;
$query = "SELECT * FROM oglasi";
$s = $conn->prepare($query);
$s->execute();

$total_results = $s->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
  $page = 1;
} else{
  $page = $_GET['page'];
}

$starting_limit = ($page-1)*$limit;
$show  = "SELECT * FROM oglasi ORDER BY id DESC LIMIT $starting_limit, $limit";
$r = $conn->prepare($show);
$r->execute();

//DELETE
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];
    $conn->query("DELETE FROM oglasi WHERE id=$id") or die($conn->error());

    $page = $_SERVER['PHP_SELF'];
    $sec = "0.1";
}

if(isset($_POST['trazi']))
{
  $lokacija = $_POST['lokacija'];
  $spol = $_POST['spol'];
  $vrsta = $_POST['vrsta'];

  $sql_trazi = "SELECT * FROM oglasi";
  $conditions = array();
  if(!empty($lokacija)) {
    $conditions[] = "lokacija='$lokacija'";
  }
  if(!empty($spol)) {
    $conditions[] = "spol='$spol'";
  }
  if(!empty($vrsta)) {
    $conditions[] = "vrsta_ljubimca='$vrsta'";
  }

  $sql = $sql_trazi;
  if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
  }

  $r = $conn->prepare($sql);
  $r->execute();
}

if(!isset($_SESSION['username'])){
  header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <title>Oglasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php 
include 'header.php';
?>

<div class="container-fluid pt-4" style="padding-left: 2%; padding-right: 2%;">
<div class="row" id="mobgrid">
    <div class="col col-2 pt-4" id="filterheader" style="background-color: #fff; border-radius: 5px; display: table; padding-bottom: 20px;">
      <div class="text-center" style="color: #000;">
          <div>
            <span class="text-dark">Aktivni oglasi: <strong><?php $nRows = $conn->query('SELECT count(*) FROM oglasi')->fetchColumn(); echo $nRows; ?></strong></span>
          </div>
          <hr>
      </div>
      <form action="" method="post">
      <label>Odaberi županiju</label>
        <div class="input-group mb-3">
          <select class="form-control" name="lokacija">
            <option value="">-----</option>
            <option>Bjelovarsko-bilogorska</option>
            <option>Brodsko-posavska</option>
            <option>Dubrovačko-neretvanska</option>
            <option>Istarska</option>
            <option>Karlovačka</option>
            <option>Koprivničko-križevačka</option>
            <option>Krapinsko-zagorska</option>
            <option>Ličko-senjska</option>
            <option>Međimurska</option>
            <option>Osječko-baranjska</option>
            <option>Požeško-slavonska</option>
            <option>Primorsko-goranska</option>
            <option>Sisačko-moslavačka</option>
            <option>Splitsko-dalmatinska</option>
            <option>Šibensko-kninska</option>
            <option>Varaždinska</option>
            <option>Virovitičko-podravska</option>
            <option>Vukovarsko-srijemska</option>
            <option>Zadarska</option>
            <option>Grad Zagreb</option>
            <option>Zagrebačka</option>
          </select>
        </div>
        <hr>

        <label>Odaberi Spol</label><br>
        <select class="form-control" name="spol">
            <option value="">-----</option>
            <option>Muško</option>
            <option>Žensko</option>
        </select>
        <hr>

        <label>Odaberi Vrstu</label><br>
        <select class="form-control" name="vrsta">
            <option value="">-----</option>
            <option>Pas</option>
            <option>Mačka</option>
            <option>Ostali ljubimci...</option>
        </select>
        <hr>

        <div class="input-group-append">
            <input type="submit" name="trazi" value="Traži" class="btn btn-info" />
        </div>
      </form>
    </div>

    <div class="col">
        <div class="row d-flex justify-content-end">
          <nav class="pl-3">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Nazad</a></li>
              <?php for ($page=1; $page <= $total_pages ; $page++){ ?>
                <li class="page-item <?php if($_GET['page']==$page) {?>active<?php } ?>" ><a class="page-link" href="<?php echo "?page=$page"; ?>"><?php  echo $page; ?></a></li>
              <?php } ?>
              <li class="page-item"><a class="page-link" href="#">Dalje</a></li>
            </ul>
          </nav>
        </div>
  
        <div class="row d-flex justify-content-start">
        <?php while($row = $r->fetch(PDO::FETCH_ASSOC))  { ?>
          <div class="" id="oglasmob">
              <div class="card mb-3 box-shadow" style="width: 14rem;">
                <?php echo "<img class='card-img-top' style='object-fit: cover;' height='230' src='".$row['image']."'>"; ?>
                <div class="card" style="padding: 10px;">
                <p class="card-title" style="font-weight: bold;"><?php echo $row["ime"]; ?></p>
                <small class="text-muted"><i class="fa fa-map-marker pr-1" aria-hidden="true"></i><?php echo $row["lokacija"]; ?></small>
                <div class="pt-3">
                    <div class="btn-group">
                      <a class="btn btn-sm btn-outline-secondary" href="view.php?id=<?php echo $row["id"]; ?>">Oglas</a>
                    </div>
                </div>
                <div class="mt-2">
                    <small>Objavljeno <?php echo $row["date"]; ?></small>
                </div>
              </div>
              </div>
          </div>
        <?php } ?>
        </div>
        
        <div class="row d-flex justify-content-end">
          <nav class="pl-3">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Nazad</a></li>
              <?php for ($page=1; $page <= $total_pages ; $page++){ ?>
                <li class="page-item <?php if($_GET['page']==$page) {?>active<?php } ?>" ><a class="page-link" href="<?php echo "?page=$page"; ?>"><?php  echo $page; ?></a></li>
              <?php } ?>
              <li class="page-item"><a class="page-link" href="#">Dalje</a></li>
            </ul>
          </nav>
        </div>
    </div>
</div>
</div>

<style>
body {
    min-height: 100vh;
    background:linear-gradient(0deg, rgba(120, 124, 128, 0.6), rgba(120, 124, 128, 0.6)), url('../login/img/ttt.jpg');
    background-repeat: no-repeat;
    background-size: cover;
  }

  #filterheader {
    min-width: 17rem;
  }

  #oglasmob {
    display: flex;
    margin: 10px;
  }

@media screen and (max-width: 1000px) {
  #mobgrid {
      display: grid;
  }
  #filterheader {
      min-width: 100%;
      padding-bottom: 10px;
      margin-bottom: 25px;
  }
}

@media screen and (max-width: 600px) {
  #mobgrid {
      display: grid;
  }
  
  #filterheader {
      min-width: 100%;
      padding-bottom: 10px;
      margin-bottom: 25px;
  }
  
  #oglasmob {
      min-width: 100%;
      display: flex;
      justify-content: center !important;
  }
}
</style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>