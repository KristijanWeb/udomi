<?php
require_once './all/config/db_connect.php';
require_once './all/config/session.php';

 
$oglasi = "SELECT * FROM oglasi ORDER BY id DESC LIMIT 8";
$oglas = $conn->query($oglasi) or die ("Bad query: #sql");


$udomljeni = "SELECT * FROM udomljeni ORDER BY id DESC LIMIT 4";
$resultudomljeni = $conn->query($udomljeni) or die ("Bad query: #sql");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pocetna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<style>
  body {
    min-height: 100vh;
    background:linear-gradient(0deg, rgba(120, 124, 128, 0.6), rgba(120, 124, 128, 0.6)), url('login/img/ttt.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
  }

  .white {
      background-color: white;
      padding: 3rem;
  }
</style>

<div class="p-1" style="background-color: white; margin: 0; min-width: 100%;">
<div class="container">
  <div class="d-flex align-items-center justify-content-between">
    <div>
        <a class="navbar-brand" href="index.php"><img src="all/img/homepets.png" height="50" alt="Slika...."></a>
    </div>
    <div class="d-flex">
        <ul class="navbar-nav">
            <li class="nav-item mr-3"><a class="btn" style="background-color: #ce84a7; color: white;" href="login.php">Prijavi se</a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="btn" style="background-color: #d6bb82; color: white;" href="signup.php">Registriraj se</a></li>
        </ul>
    </div>
  </div>
</div>
</div>

<main role="main">
    <div class="container">
        <div class="row" id="block">
            <div class="col d-flex align-items-center" id="indextext">
                <div class="p-5">
                    <p class="text-white">
                        Web aplikacija Udomi namijenjena je udomljavanju ljubimaca.
                        Glavna ideja je olakšati njihov put do novog doma te promovirati samo udomljavanje!
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="p-5">
                    <img class="rounded-pill w-100" src="login/img/pic.jpg" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="white">
        <div class="text-center text-white pb-5">
            <div class="text-center text-dark" id="svioglasi">
                <h1>TRAŽE DOM</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php while($row = $oglas->fetch(PDO::FETCH_ASSOC))  { ?>
                <div class="col-md-3" id="oglasmob">
                    <div id="og" class="card mb-3 box-shadow" style="width: 12rem;">
                    <?php echo "<img class='card-img-top' style='object-fit: cover;' height='230' src='./all/".$row['image']."'>"; ?>
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $row["ime"]; ?></h5>
                        <p class="card-text" style="font-size: 12px;"><?php echo substr($row["opis"], 0, 40) ?></p>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-outline-secondary" href="oglasall/viewall.php?id=<?php echo $row["id"]; ?>">Oglas</a>
                        </div>
                    </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="text-center pt-5">
                <a href="oglasall/oglasall.php" class="btn btn-secondary">Oglasi</a>
            </div>
        </div>
    </div>

    <div class="text-center text-white p-5">
        <div class="text-center" id="svioglasi">
            <h1>UDOMLJENI</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php while($row = $resultudomljeni->fetch(PDO::FETCH_ASSOC))  { ?>
            <div class="col-md-3" id="oglasmob">
                <div class="card mb-3 box-shadow" style="width: 12rem;">
                <?php echo "<img class='card-img-top' height='230' src='./all/".$row['image']."'>"; ?>
                <div class="card-body">
                <h5 class="card-title"><?php echo $row["ime"]; ?></h5>
                    <p class="card-text" style="font-size: 12px;"><?php echo substr($row["opis"], 0, 40) ?></p>
                    <div>
                        <small class="text-muted"><i class="fa fa-map-marker pr-1" aria-hidden="true"></i><?php echo $row["lokacija"]; ?></small>
                    </div>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="text-center pt-5">
            <a class="btn btn-secondary" href="./all/udomljeni.php">Udomljeni</a>
        </div>
    </div>

</main>

<footer style="padding-bottom: 3px; background-color: white;">
    <hr>
    <div class="container">
        <p>&copy; KristijanWeb <?php echo date("Y") ?></p>
    </div>
</footer>

<style>
@media screen and (max-width: 700px) {
  #naslov {
      font-size: 3rem;
      text-align: center;
  }
  
  #oglasmob {
      min-width: 100%;
      display: flex;
      justify-content: center !important;
  }

  #svioglasi h1 {
      font-size: 20px;
  }

  #block {
      display: block;
  }

  #indextext {
      text-align: center;
  }
}
</style>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>