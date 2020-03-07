<?php
include_once 'config/db_connect.php';
require_once 'config/session.php';

$lista = "SELECT * FROM users";
$list = $conn->query($lista) or die ("Bad query: #sql");
    
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id") or die($conn->error());

    $page = $_SERVER['PHP_SELF'];
    $sec = "0.1";
}

if(!isset($_SESSION['username'])){
  header("location: ../login.php");
}
if($_SESSION['username'] == 'admin' && $_SESSION['username'] == 'admin1'){
  header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <title>Lista</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>
<body>
<style>
  body {
    background-color: #cec6c6 !important;
  }
</style>
<?php 
include 'header.php';
?>

<div class="text-center p-5">
    <div>
        <h2>Lista svih registriranih korisnika</h2>
    </div>
    <div>
      <input id="myInput" type="text" placeholder="Trazi korisnika..">
    </div>
</div>

<div class="container">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Korisničko ime</th>
          <th scope="col">Email</th>
          <th scope="col">Mobitel</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <?php while($row = $list->fetch(PDO::FETCH_ASSOC)) { ?>
      <tbody id="myTable">
        <tr>
          <th scope="row"><?php echo $row["Id"] ?></th>
          <td><?php echo $row["username"] ?></td>
          <td><?php echo $row["email"] ?></td>
          <td><?php echo $row["mobitel"] ?></td>
          <td><a href="lista.php?delete=<?php echo $row["Id"]; ?>" class="btn btn-danger">Obriši</a></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
</div>

<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>