<?php 
// $username = "root";
// $password = "";
// $dsn = "mysql:host=localhost; dbname=udomljavanje";

$username = "kristij2_user";
$password = "Udomljavanje11;;";
$dsn = "mysql:host=localhost; dbname=kristij2_data";

// Create connection
try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Fail to connect to the database ".$e->getMessage();
}

?>