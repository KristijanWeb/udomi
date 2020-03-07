<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

$id = $_GET['id'];

$oglasi = "SELECT * FROM oglasi WHERE id=$id";
$result = $conn->query($oglasi) or die ("Bad query: #sql");


if(isset($_POST['update'])){

    $id = $_GET['id'];
    $vrsta_ljubimca = $_POST['vrsta_ljubimca'];
    $ime = $_POST['ime'];
    $godine = $_POST['godine'];
    $spol = $_POST['spol'];
    $opis = $_POST['opis'];
    $lokacija = $_POST['lokacija'];
    $kontakt = $_POST['kontakt'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $ime_i_prezime = $_POST['ime_i_prezime'];
    
    $zb = $_POST['zaraznebolesti'];
    $bs = $_POST['bjesnoca'];
    $cip = $_POST['cip'];
    $zus = $_POST['zivotustanu'];
    $dz = $_POST['drugezivotinje'];
    $steri = $_POST['steriliziran'];

    $images = count($_FILES['image']['name']);

    for($i=0;$i<$images;$i++){
        $image = "uploads/".$_FILES['image']['name'][$i];
        $target = "./uploads/".basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }
    $SQLInsert = "UPDATE oglasi SET vrsta_ljubimca = '$vrsta_ljubimca', ime = '$ime', godine = '$godine', spol = '$spol', opis = '$opis', 
                            lokacija = '$lokacija', kontakt = '$kontakt', korisnicko_ime = '$korisnicko_ime', ime_i_prezime = '$ime_i_prezime', image = '$image',
                            zaraznebolesti = '$zb', bjesnoca = '$bs', cip = '$cip', zivotustanu = '$zus', drugezivotinje = '$dz', steriliziran = '$steri' WHERE id=$id";
    $statement = $conn->prepare($SQLInsert);
    $statement->execute();

    header("Location: myoglas.php");
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
  .form-group label {
    color: #fff;
}
</style>

<?php 
include 'header.php';
?>


<div class="container p-5">
    <h1 class="text-white">Uredi oglas</h1>

    <?php if($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <form action="edit.php?id=<?php echo $_GET['id'];?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Ime</label>
                <input type="text" name="ime" value="<?php echo $row['ime'] ?>" class="form-control" placeholder="Ime">
            </div>
            <div class="form-group col-md-3">
                <label>Vrsta</label>
                <select name="vrsta_ljubimca" class="form-control">
                    <option value="<?php echo $row['vrsta_ljubimca'] ?>"><?php echo $row['vrsta_ljubimca'] ?></option>
                    <option>Pas</option>
                    <option>Mačka</option>
                    <option>Ostali ljubimci</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Dob</label>
                <input type="text" name="godine" class="form-control" placeholder="Godine" value="<?php echo $row['godine'] ?>">
            </div>
            <div class="form-group col-md-3">
                <label>Spol</label>
                <select name="spol" class="form-control">
                    <option value="<?php echo $row['spol'] ?>"><?php echo $row['spol'] ?></option>
                    <option>Muško</option>
                    <option>Žensko</option>
                </select>
            </div>

            <div class="form-group col-md-3 text-white">
                <span>Cijepljen protiv zaraznih bolesti</span><br>
                <input type="radio" name="zaraznebolesti" value="Da"> Da<br>
                <input type="radio" name="zaraznebolesti" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
                <span>Cijepljen protiv bjesnoće</span><br>
                <input type="radio" name="bjesnoca" value="Da"> Da<br>
                <input type="radio" name="bjesnoca" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
                <span>Čipiran</span><br>
                <input type="radio" name="cip" value="Da"> Da<br>
                <input type="radio" name="cip" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
                <span>Naučen na život u stanu</span><br>
                <input type="radio" name="zivotustanu" value="Da"> Da<br>
                <input type="radio" name="zivotustanu" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
                <span>Naučen na druge životinje</span><br>
                <input type="radio" name="drugezivotinje" value="Da"> Da<br>
                <input type="radio" name="drugezivotinje" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
                <span>Sterilizirana/Kastriran</span><br>
                <input type="radio" name="steriliziran" value="Da"> Da<br>
                <input type="radio" name="steriliziran" value="Ne"> Ne<br>
            </div>
            <div class="form-group col-md-3 text-white">
            </div>
            
            <div class="form-group col-md-6">
                <label>Opis</label>
                <textarea name="opis" class="form-control" placeholder="Opis" cols="20" rows="10"><?php echo $row['opis'] ?></textarea>
            </div>
            <div class="form-group col-md-6">
                <label>Lokacija</label>
                <select name="lokacija" class="form-control">
                    <option value="<?php echo $row['lokacija'] ?>"><?php echo $row['lokacija'] ?></option>
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
            <div class="form-group col-md-6">
                <label>Kontakt</label>
                <input type="text" name="kontakt" value="<?php echo $row['kontakt'] ?>" class="form-control" placeholder="Kontakt">
            </div>
            <div style="display: none;" class="form-group col-md-6">
                <label>Korisničko ime</label>
                <input type="text" name="korisnicko_ime" value="<?php echo $_SESSION['username'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Ime i prezime</label>
                <input type="text" name="ime_i_prezime" value="<?php echo $row['ime_i_prezime'] ?>" class="form-control" placeholder="Upisi svoje ime i prezime">
            </div>
        </div>
        <div class="form-group" style="background-color: wheat; padding: 2rem;">
            <div>
            <?php while($pic = $slik->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php if($row['korisnicko_ime'] == $pic['userid'] && $row['vrijeme'] == $pic['vrijeme']){ ?>
                <img style="height: 140px; margin: 5px;" style="cursor: zoom-in"  class="img-thumbnail" src="<?php echo $pic['image']; ?>">
            <?php } ?>
            <?php } ?>
            </div>
            <div>
                <h3>Izaberite sliku</h3>
            </div>
            <input required type="file" name="image[]" multiple>
        </div>
        <input type="submit" name="update" class="btn btn-primary" value="Objavi">
    </form>
    <?php } ?>
</div>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>