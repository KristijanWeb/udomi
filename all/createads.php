<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

if(isset($_POST['submit'])) {

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

$date = date('d.m.Y');
$userid = $_POST['userid'];

$images = count($_FILES['file']['name']);

try {
    
    for($i=0;$i<$images;$i++){
        $image = "uploads/".$_FILES['file']['name'][$i];
        $target = "uploads/".basename($image);

        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target)) {
            header('location: dashboard.php');
        }else{
            echo "Failed to upload image";
        }
        
        $img = "INSERT INTO slike (image, userid) VALUES (:image, :userid)";
        $imgg = $conn->prepare($img);
        $imgg->execute(array(':image' => $image, ':userid' => $userid));
    }

    $SQLInsert = "INSERT INTO oglasi (vrsta_ljubimca,ime,godine,spol,opis,lokacija,kontakt,korisnicko_ime,ime_i_prezime, date, image, zaraznebolesti, bjesnoca, cip, 
                                    zivotustanu, drugezivotinje, steriliziran) 
                VALUES (:vrsta_ljubimca, :ime, :godine, :spol, :opis, :lokacija, :kontakt, :korisnicko_ime, :ime_i_prezime, :date, :image, :zaraznebolesti, :bjesnoca, 
                        :cip, :zivotustanu, :drugezivotinje, :steriliziran)";
    $statement = $conn->prepare($SQLInsert);
    $statement->execute(array(':vrsta_ljubimca' => $vrsta_ljubimca, ':ime' => $ime, ':godine' => $godine,
                            ':spol' => $spol, ':opis' => $opis, ':lokacija' => $lokacija, ':kontakt' => $kontakt,
                            ':korisnicko_ime' => $korisnicko_ime, ':ime_i_prezime' => $ime_i_prezime,':date' => $date, ':image' => $image,
                            ':zaraznebolesti' => $zb, 'bjesnoca' => $bs, ':cip' => $cip, ':zivotustanu' => $zus, ':drugezivotinje' => $dz,
                            ':steriliziran' => $steri));

    if($statement->rowCount() == 1 && $imgg->rowCount() == 1) {
        header('location: dashboard.php');
    }
    else {
        echo 'Nije uspjesno';
    }
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}

if(!isset($_SESSION['username']))
{
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
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

<div class="text-center p-3 text-white">
    <h2>Objavi oglas</h2>
</div>
<div class="container p-4">
    <form action="createads.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Ime</label>
                <input type="text" name="ime" class="form-control" placeholder="Ime" required>
            </div>
            <div class="form-group col-md-3">
                <label>Vrsta</label>
                <select name="vrsta_ljubimca" class="form-control" required>
                    <option value="">Izaberi...</option>
                    <option>Pas</option>
                    <option>Mačka</option>
                    <option>Ostali ljubimci...</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Dob</label>
                <input type="text" name="godine" class="form-control" placeholder="Godine" required>
            </div>
            <div class="form-group col-md-3">
                <label>Spol</label>
                <select name="spol" class="form-control" required>
                    <option value="">Izaberi...</option>
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
                <textarea name="opis" class="form-control" placeholder="Opis" cols="20" rows="10" required></textarea>
            </div>
            <div class="form-group col-md-3">
                <label>Lokacija</label>
                <select name="lokacija" class="form-control" required>
                    <option value="">Odaberi županiju..</option>
                    <option>Bjelovarsko-bilogorska</option>
                    <option>Brodsko-posavska</option>
                    <option>Dubrovačko-neretvanska</option>
                    <option>Istarska</option>
                    <option>Karlovačka</option>
                    <option>Koprivničko-Križevačka</option>
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
            <div class="form-group col-md-3">
                <label>Kontakt</label>
                <input type="text" name="kontakt" class="form-control" placeholder="Kontakt" required>
            </div>
            <div style="display: none;" class="form-group col-md-6">
                <label>Korisničko ime</label>
                <input type="text" name="korisnicko_ime" value="<?php echo $_SESSION['username'] ?>" class="form-control" required>
                <label>Id</label>
                <input type="text" name="userid" value="<?php echo $_SESSION['username'] ?>" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Ime i prezime</label>
                <input type="text" name="ime_i_prezime" class="form-control" placeholder="Upisi svoje ime i prezime" required>
            </div>
        </div>
        <div class="form-group col-md-10" style="background-color: #82bcecb0; padding: 20px; border-radius: 15px;">
            <div>
                <h3>Izaberite sliku</h3>
            </div>
            <div class="mt-4 mb-4">
                <div id="uploaded_image"></div>
                <div class="progress mt-4">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="testt"></div>
                    </div>
                </div>
            </div>
            <input type="file" name="file[]" id="file" multiple>
        </div>

        <input type="submit" name="submit" class="btn btn-primary" value="Objavi">
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
function readImage(file) {
  var reader = new FileReader();
  var image  = new Image();

  reader.readAsDataURL(file);  
  reader.onload = function(_file) {
    image.src = _file.target.result;
    image.onload = function() {
      $('#uploaded_image').append('<img height=100 src="' + this.src + '"> ');
    };    
  };

}
$("#file").change(function (e) {
  var F = this.files;
  if (F && F[0]) {
    for (var i = 0; i < F.length; i++) {
      readImage(F[i]);
    }
  }
});

$(document).ready(function(){
    $(document).on('change', '#file', function(){
        var form_data = new FormData();
        $.ajax({
            url:"upload.php",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $('.progress-bar').width('50%');
                $('.testt').html('<span>50%</span>');
            },
            success:function(data)
            {
                $('.testt').html('<span>100%</span>');
                $('.progress-bar').width('100%');
            }
        });
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>