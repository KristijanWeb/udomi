<?php
require_once 'config/db_connect.php';

session_start();
unset($_SESSION["username"]);

header("location: ../index.php");
?>