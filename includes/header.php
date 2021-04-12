<?php 
require_once("config.php");
require_once("classes/user.php");
$userLoggedIn = isset($_SESSION["userloggedIn"])?$_SESSION["userloggedIn"]:"";
$userLoggedInObj = new User($con,$userLoggedIn);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Empire</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<body>
    <div id="pageContainer">
    <!-- NavBar -->
        <div id="mastHeadContainer">
            <button id="showHideSide"><img src="assets/images/icons/menu.png" alt="menu_icon"></button>
            <a href="index.php"><img src="assets/images/icons/logo.png" alt="site_logo"></a>
            <div class="searchBarContainer">
                <form action="search.php" method="GET">
                    <input type="text" placeholder="Search ...." name="term" class="searchBar">
                    <button>
                        <img src="assets/images/icons/search.png" alt="searchIcon">
                    </button>
                </form>
            </div>
            <div class="rightIcons">
                <a href="upload.php">
                    <img class = "upload" src="assets/images/icons/upload.png" alt="upload_icon">
                </a>    
                <a href="#">
                    <img class = "upload" src="assets/images/profilePictures/default.png" alt="profile_icon">
                </a>  
            </div>
            
        </div>
    <!-- SideNav -->
        <div id="sideNavContainer" style="display:none;"> </div>
        <div id="mainSectionContainer">
            <div id="mainContentContainer">