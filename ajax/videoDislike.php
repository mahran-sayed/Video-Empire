<?php
require_once("../includes/config.php");
require_once("../includes/classes/user.php");
require_once("../includes/classes/video.php");

$userLoggedIn = $_SESSION["userloggedIn"];
$videoId = $_POST["videoId"];

$userLoggedInObj = new User($con,$userLoggedIn);
$video = new Video($con,$userLoggedInObj,$videoId);

echo $video->dislike();



?>