<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

$oglasi = "SELECT * FROM udomljeni";
$result = $conn->query($oglasi) or die ("Bad query: #sql");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Moji oglasi</title>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
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
    if(isset($_SESSION['username'])){
        include 'header.php';
    }
    else {
            echo '<div class="p-1" style="background-color: white; margin: 0; min-width: 100%;">';
            echo '<div class="container">';
            echo '<div class="d-flex align-items-center justify-content-between">';
            echo '<div>';
            echo        '<a class="navbar-brand" href="../index.php"><img src="img/homepets.png" height="50" alt="Slika...."></a>';
            echo    '</div>';
            echo    '<div class="d-flex">';
            echo        '<ul class="navbar-nav">';
            echo            '<li class="nav-item mr-3"><a class="btn" style="background-color: #ce84a7; color: white;" href="../login.php">Prijavi se</a></li>';
            echo       '</ul>';
            echo        '<ul class="navbar-nav">';
            echo            '<li class="nav-item"><a class="btn" style="background-color: #d6bb82; color: white;" href="../signup.php">Registriraj se</a></li>';
            echo        '</ul>';
            echo    '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
    }
?>

<div class="text-center p-5 text-white">
    <h1>Sretno udomljeni</h1>
    <hr style="height: 1px; background-color: white;">
</div>

<div class="container pt-4">
    <div class="row d-flex justify-content-center">
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC))  { ?>
            <div class="col-md-3" id="oglasmob">
                <div class="card mb-3 box-shadow" style="width: 15rem;">
                <?php echo "<img class='card-img-top' height='170' src='".$row['image']."'>"; ?>
                <div class="card-body">
                <h5 class="card-title"><?php echo $row["ime"]; ?></h5>
                    <p class="card-text"><?php echo substr($row["opis"], 0, 40) ?></p>
                    <div>
                        <small class="text-muted"><i class="fa fa-map-marker pr-1" aria-hidden="true"></i><?php echo $row["lokacija"]; ?></small>
                    </div>
                </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>