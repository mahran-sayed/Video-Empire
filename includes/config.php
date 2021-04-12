<?php
ob_start();
session_start();
date_default_timezone_set("Africa/Cairo");
try{
$con = new PDO("mysql:host=localhost;dbname=videoempire",'mahran','0162310296');
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}catch(PDOException $e){
    echo "Connection failed".$e->getMessage();
}

?>