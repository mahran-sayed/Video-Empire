<?php 
require_once("includes/config.php");
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/account.php");
require_once("includes/classes/constants.php");
$account = new Account($con);
if(isset($_POST["submitButton"])){
    $uname = formSanitizer::sanitizeFormUsername($_POST["uname"]);
    $pw = formSanitizer::sanitizeFormPassword($_POST["pw"]);
    $wasSuccessful = $account->login($uname,$pw);
    if($wasSuccessful){
        $_SESSION["userloggedIn"] = $uname;
        header("Location:index.php");
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Empire</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<body>

<div class="signinContainer">
    <div class="column">
        <div class="header">
            <img src="assets/images/icons/logo.png" alt="Site Logo">
            <h3>Sign Up</h3>
            <span>to continue to videoTube</span>
        </div>
        <div class="loginForm">
            <?=$account->getError(constants::$failedLogin) ?>
            <form action="signIn.php" method="POST">
                <input type="text" name = "uname" placeholder = "User Name" autocomplete ="off" required>
                <input type="password" name = "pw" placeholder = "Password" autocomplete ="off" required>
                <input type="submit" name = "submitButton" value = "Login" autocomplete ="off" required>
            </form>



        </div>
        <a class="signInMessage" href="signUp.php">Need an account? Sign Up here!</a>
    </div>
</div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
