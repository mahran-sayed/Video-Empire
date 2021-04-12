<?php 
require_once("includes/header.php");
require_once("includes/classes/videoUploadData.php");
require_once("includes/classes/videoProcessor.php");

if(!isset($_POST["uploadButton"])){
    echo "File not sent";
    exit();
    
}else{
    $videoUploadObj = new videoUploadData($_FILES["fileInput"],$_POST["titleInput"],$_POST["descriptionInput"],$_POST["privacyInput"],$_POST["categoryInput"],$userLoggedInObj->getUsername());
    $videoProcessorObj = new videoProcessor($con);
    $wasSuccessful = $videoProcessorObj->upload($videoUploadObj);
    if($wasSuccessful){
        echo "Updated Successfully";
    }
}

?>
