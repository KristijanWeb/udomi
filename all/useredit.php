<?php 
require_once 'config/db_connect.php';
require_once 'config/session.php';

$id = $_GET['id'];

$oglasi = "SELECT * FROM users WHERE Id=$id";
$result = $conn->query($oglasi) or die ("Bad query: #sql");

if(isset($_POST['update'])){
    $id = $_GET['id'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $mobitel = $_POST['mobitel'];
    $password = $_POST['userpass'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $SQLInsert = "UPDATE users SET ime = '$ime', prezime = '$prezime', email = '$email', mobitel = '$mobitel', password = '$hashed_password' WHERE Id=$id";
    $statement = $conn->prepare($SQLInsert);
    $statement->execute();

    $msg = "Podatci su uspješno izmjenjeni!";
    header("Location: userview.php?msg=$msg");
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
    <title>Edit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<?php 
include 'header.php';
?>

<div class="container p-5">
    <h1>Izmjeni podatke</h1>

    <?php if($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <form action="useredit.php?id=<?php echo $_GET['id'];?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Ime</label>
                <input type="text" name="ime" value="<?php echo $row['ime'] ?>" class="form-control" placeholder="Ime">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Prezime</label>
                <input type="text" name="prezime" value="<?php echo $row['prezime'] ?>" class="form-control" placeholder="Prezime">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Kontakt</label>
                <input type="text" name="mobitel" value="0<?php echo $row['mobitel'] ?>" class="form-control" placeholder="Kontakt">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nova Lozinka</label>
                <input type="password" name="userpass" class="form-control" id="myInput" placeholder="Nova Lozinka" required>
                <input type="checkbox" class="mt-3 mb-3" onclick="myFunction()">Prikazi Lozinku
                <p class="alert alert-info">Kod svake izmjene je potrebna potvrda lozinke ili postavite novu!</p>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <input style="cursor: pointer;" type="submit" name="update" class="btn btn-sm btn-primary" value="Spremi promjene">
            </div>
        </div>
    </form>
    <?php } ?>
</div>

<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>