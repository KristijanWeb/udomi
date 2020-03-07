<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
  require_once 'config/session.php';

  $oglasi = "SELECT * FROM oglasi";
  $oglas = $conn->query($oglasi) or die ("Bad query: #sql");
?>

<nav class="navbar navbar-expand-lg" style="background-color: #e6e6e6;">
  <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#myNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="myNavbar" style="justify-content: space-between">
    <a class="navbar-brand pl-3" href="#"><img src="img/homepets.png" height="50" alt="Slika...."></a>
    <?php if(isset($_SESSION['username'])){ ?>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link btn btn-dark" href="createads.php">Objavi oglas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" href="dashboard.php">Oglasi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" href="udomljeni.php">Udomljeni</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 pr-3">

      <li class="submenu">
        <div class="d-flex align-items-center" id="usermain">
          <div id="down">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            <span class="btn dropbtn user" style="cursor: pointer;" onClick="myFunc()">Moj profil</span>
            <i style="color: #77858a;" class="fa fa-arrow-down" aria-hidden="true"></i>
          </div>

          <div id="up">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            <span class=" btn dropbtn user" style="cursor: pointer;" onClick="myClose()">Moj profil</span>
            <i style="color: #77858a;" class="fa fa-arrow-up" aria-hidden="true"></i>
          </div>
        </div>

        <div class="dropdown-content" id="menu">
          <a href="userview.php" class="nav-link text-dark">Profil</a>
          <a class="nav-link text-dark" href="myoglas.php?korisnicko_ime=<?php echo $_SESSION['username']; ?>">Moji oglasi</a>
          <a href="inbox.php" class="nav-link text-dark">Poruke</a>
          <?php if($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'hrabre.njuske'){ ?>
            <a class="nav-link text-dark" href="lista.php">Lista korisnika</a>
          <?php } ?>
          <a class="nav-link text-white bg-danger" href="logout.php">Odjava</a>
        </div>
      <li>
    </ul>
    </form>
    <?php } ?>
  </div>
</nav>

<style>
.dropdown-content{
  display:none;
  position:absolute;
  min-width: 150px;
  margin-top:17px;
  background-color: #e6e6e6;
  margin-left:-40px;
  z-index: 99;
  text-align: center;
}
.dropdown-content a{
  display:block;
  padding: 14px 26px;
  border-bottom: 1px solid transparent;
  border-top: 1px solid transparent;
}
.dropdown-content a span{
  margin-left:-10px;
  margin-right: 10px;
}
.dropdown-content a:hover{
  border-bottom: 1px solid #17a2b8;
  border-top: 1px solid #17a2b8;
}

#up {
  display: none;
}

@media screen and (max-width: 600px) {
  .dropdown-content {
    min-width: 100%;
  }
}
</style>

<script>

function myFunc(){
  document.getElementById("menu").style.display = 'block';
  document.getElementById("down").style.display = 'none';
  document.getElementById("up").style.display = 'block';
}

function myClose(){
  document.getElementById("menu").style.display = 'none';
  document.getElementById("down").style.display = 'block';
  document.getElementById("up").style.display = 'none';
}

</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>