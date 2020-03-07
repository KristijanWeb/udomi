<?php 
require_once 'config/db_connect.php';
require_once 'config/session.php';


if(isset($_SESSION['username']) and isset($_GET['user'])){
    if(isset($_POST['text'])){
        if($_POST['text'] != ''){
            $salje = $_SESSION['username'];
            $prima = $_GET['user'];
            $poruka = $_POST['text'];
            $vrijeme = date('H:i');
    
            $q = "INSERT INTO message (user_salje, user_prima, poruka, date) VALUES (:user_salje, :user_prima, :poruka, :date)";
            $qq = $conn->prepare($q);
            $qq->execute(array(':user_salje' => $salje, ':user_prima' => $prima, ':poruka' => $poruka, ':date' => $vrijeme));
    
            if($qq)
            {
            ?>
                <div class="mess">
                    <p><?php echo $poruka; ?></p>
                </div>
            <?php 
            }
            else {
                echo $qq;
            }
        }
        else {
            echo 'Molim napišite nešto!';
        }
    }
}
?>