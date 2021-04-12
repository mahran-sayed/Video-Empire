<?php 
require_once("includes/header.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/videoPlayer.php");
require_once("includes/classes/videoInfoSection.php");
require_once("includes/classes/videoControls.php");
require_once("includes/classes/buttonProvider.php");


?>
<?php
if(isset($_GET["id"])){
    $videoObj = new Video($con,$userLoggedIn,$_GET["id"]);
    $videoObj->incrementViews();
}else{
    echo "No url passed into the page";
    exit();
}
?>
<script src="assets/js/videoPlayer.js"></script>
<div class="watchLeftColumn">
<?php

$videoPlayer = new VideoPlayer($videoObj);
echo $videoPlayer->create(true);
$videoInfo = new VideoInfoSection($con,$videoObj,$userLoggedInObj);
echo $videoInfo->create();


?>
</div>
<div class="suggestions">
</div>

<?php require_once("includes/footer.php"); ?>
