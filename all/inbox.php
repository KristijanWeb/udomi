<?php
require_once 'config/db_connect.php';
require_once 'config/session.php';

$poruke = 'SELECT * FROM message WHERE user_prima = "'.$_SESSION['username'].'" OR user_salje = "'.$_SESSION['username'].'" ';
$mm = $conn->query($poruke) or die ("Bad query: #sql");

if(!isset($_SESSION['username'])){
  header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poruke</title>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<style>
  body {
    min-height: 100vh;
    background-color: white;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .grey {
      border: 1px solid #3574d4;
      padding: 10px; 
      background-color: white;
      border-radius: 10px;
  }

  #profimg {
    float: left;
    margin-right: 10px;
  }

  .right-col {
      background:linear-gradient(0deg, rgba(120, 124, 128, 0.6), rgba(120, 124, 128, 0.6)), url('../login/img/ttt.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 10px;
      color: white;
  }

  .poruke {
      height: 80vh;
      width: 100%;
      margin: 0px auto;
      overflow: auto;
      position: relative;
  }
  .poruka {
      padding: 5px;
      height: 85%;
      overflow: auto;
  }
  .textarea {
      width: 100%;
      height: 10%;
      position: absolute;
      bottom: 1%;
  }
  .mess {
      border: 1px solid #4eb9d6;
      border-radius: 10px;
      background-color: #fff;
      color: #000;
      padding: 5px;
      margin-bottom: 10px;
  }
  .messs {
      border: 1px solid #4eb9d6;
      border-radius: 10px;
      background-color: #bfeaa6;
      color: #000;
      padding: 5px;
      margin-bottom: 10px;
      text-align: right;
  }

  @media screen and (max-width: 600px){
    .left-col {
      min-width: 100%;
      display: flex;
    }
    #right-col {
      min-width: 100%;
    }
  }
</style>
<?php 
include 'header.php';
?>
<div class="container pt-4">

  <div class="row">
    <div class="col col-3 left-col">
    <?php 
    $qqqq = 'SELECT DISTINCT user_salje, user_prima FROM message WHERE user_salje = "'.$_SESSION['username'].'" OR user_prima = "'.$_SESSION['username'].'"
    ORDER BY date DESC';
    $resm = $conn->query($qqqq) or die ("Bad query: #sql");
    
    if($resm)
    {
      if($resm->rowCount() > 0)
      { 
        $counter = 0;
        $added_user = array();
        while($row = $resm->fetch(PDO::FETCH_ASSOC))
        {
          $korisnik_salje = $row['user_salje'];
          $korisnik_prima = $row['user_prima'];

          if($_SESSION['username'] == $korisnik_salje)
          {
            if(in_array($korisnik_prima, $added_user))
            {

            }
            else {
            ?> 
            <div class="grey">
              <div class="pb-1">
                  <a href="inbox.php?user=<?php echo $row['user_prima'] ?>"><span><?php echo $korisnik_prima; ?></span></a>
              </div>
            </div>
            <?php
            $added_user = array($counter => $korisnik_prima);
            $counter++;
            }
          }
          elseif($_SESSION['username'] == $korisnik_prima)
          {
            if(in_array($korisnik_salje, $added_user))
            {

            }
            else {
            ?> 
            <div class="grey">
              <div class="pb-1">
                <a href="inbox.php">
                  <a href="inbox.php?user=<?php echo $row['user_salje'] ?>"><span><?php echo $korisnik_salje; ?></span></a>
                </a>
              </div>
            </div>
            <?php
            $added_user = array($counter => $korisnik_salje);
            $counter++;
            }
          }
        }
      }
      else {
        echo 'Nema poruka';
      }
    }
    else {
      echo $resm;
    }
    ?>
    </div>
    <div class="col right-col" style="" id="right-col">
        <div class="poruke" id="poruke">
          <div class="poruka">
          <?php
            $no_message = false;
            
            if(isset($_GET['user']))
            {
              $_GET['user'] == $_GET['user'];
            }
            else {
              $poruke = 'SELECT user_salje, user_prima FROM message WHERE user_salje = "'.$_SESSION['username'].'" OR user_prima = "'.$_SESSION['username'].'" 
                        ORDER BY date DESC LIMIT 1';
              $r = $conn->query($poruke) or die ("Bad query: #sql");

              if($r)
              {
                if($r->rowCount() > 0)
                {
                  while($row = $r->fetch(PDO::FETCH_ASSOC))
                  {
                    $salje = $row['user_salje'];
                    $prima = $row['user_prima'];

                    if($_SESSION['username'] == $salje)
                    {
                      $_GET['user'] = $prima;
                    }
                    else {
                      $_GET['user'] = $salje;
                    }
                  }
                }
                else {
                  echo 'Nema poruka';
                  $no_message = true;
                }
              }
              else {
                echo 'Nema poruka';
              }
            }

            if($no_message == false){
            $poruke = 'SELECT * FROM message WHERE
                      user_salje="'.$_SESSION['username'].'" AND user_prima="'.$_GET['user'].'" 
                      OR
                      user_salje="'.$_GET['user'].'" AND user_prima="'.$_SESSION['username'].'" ';
            $m = $conn->query($poruke) or die ("Bad query: #sql");

            if($m)
            {   
              while($row = $m->fetch(PDO::FETCH_ASSOC))
              {
                $salje = $row['user_salje'];
                $prima = $row['user_prima'];
                $poruka = $row['poruka'];
                $vrijeme = $row['date'];

                if($salje == $_SESSION['username'])
                {
                ?>
                  <div class="mess">
                      <p><?php echo $poruka; ?></p>
                      <div>
                        <small><?php echo $vrijeme; ?></small>
                      </div>
                  </div>
                <?php 
                }
                else 
                {
                  ?>
                  <div class="messs">
                      <p><?php echo $poruka; ?></p>
                      <div>
                        <small><?php echo $vrijeme; ?></small>
                      </div>
                  </div>
                  <?php
                }
              }
            }
            else {
              echo $m;
            }
          }
            ?>
          </div>
          <hr>
          <form method="post" id="message-form">
            <textarea class="textarea" id="message-text" placeholder="Napisi poruku"></textarea>
          </form>
        </div>
    </div>
  </div>
</div>


<script>
$("document").ready(function(event){

  $("#right-col").on('submit', '#message-form', function(){
    var message_text = $("#message-text").val();
    $.post("proces.php?user=<?php echo $_GET['user']; ?>",
    {
      text: message_text,
    },
    function(data,status){
      $("#message-text").val("");
      document.getElementById("poruke").innerHTML += data;
    }
    );
  });

  $("#right-col").keypress(function(e){
    if(e.keyCode == 13 && !e.shiftKey){
      $("#message-form").submit();
    }
  });

});
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>