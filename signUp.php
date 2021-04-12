<?php 
require_once("includes/config.php");
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/account.php");
require_once("includes/classes/constants.php");
$account = new Account($con);
if(isset($_POST["submitButton"])){
    $fname = formSanitizer::sanitizeFormString($_POST["fname"]);
    $lname = formSanitizer::sanitizeFormString($_POST["lname"]);
    $em1 = formSanitizer::sanitizeFormEmail($_POST["em1"]);
    $em2 = formSanitizer::sanitizeFormEmail($_POST["em2"]);
    $pw1 = formSanitizer::sanitizeFormPassword($_POST["pw1"]);
    $pw2 = formSanitizer::sanitizeFormPassword($_POST["pw2"]);
    $uname = formSanitizer::sanitizeFormUsername($_POST["uname"]);
    $wasSuccessful = $account->register($fname,$lname,$uname,$em1,$em2,$pw1,$pw2);
    if($wasSuccessful){
        $_SESSION["userloggedIn"] = $uname;
        header("Location:index.php");
    }
}
function getValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
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
            <form action="signUp.php" method="POST">
                <?=$account->getError(constants::$firstNameCharacters) ?>
                <input type="text" name = "fname" value='<?= getValue("fname")?>' placeholder = "First Name" autocomplete ="off" required>
                <?=$account->getError(constants::$lastNameCharacters) ?>
                <input type="text" name = "lname" value='<?= getValue("lname")?>' placeholder = "Last Name" autocomplete ="off" required>
                <?=$account->getError(constants::$usernameCharacters) ?>
                <?=$account->getError(constants::$usernameToken) ?>
                <input type="text" name = "uname" value='<?= getValue("uname")?>' placeholder = "User Name" autocomplete ="off" required>
                <?=$account->getError(constants::$emailNoMatch) ?>
                <?=$account->getError(constants::$emailNotValid) ?>
                <?=$account->getError(constants::$emailToken) ?>

                <input type="email" name = "em1" value='<?= getValue("em1")?>' placeholder = "Email" autocomplete ="off" required>
                <input type="email" name = "em2" value='<?= getValue("em2")?>' placeholder = "Confirm Email" autocomplete ="off" required>
                <?=$account->getError(constants::$passwordNoMatch) ?>
                <?=$account->getError(constants::$passwordNotValid) ?>
                <?=$account->getError(constants::$passwordCharacters) ?>

                <input type="password" name = "pw1" placeholder = "Password" autocomplete ="off" required>
                <input type="password" name = "pw2" placeholder = "Confirm Password" autocomplete ="off" required>
                <input type="submit" name = "submitButton" placeholder = "submit" autocomplete ="off" required>
            </form>



        </div>
        <a class="signInMessage" href="signIn.php">Already have an account? Sign in here!</a>
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
