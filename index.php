<?php require_once("includes/header.php"); ?>
<?php
if(isset($_SESSION["userloggedIn"])){
    echo "user is logged in ".$_SESSION["userloggedIn"];
}else{
    echo "User not logged in";
}
?>

<?php require_once("includes/footer.php"); ?>
