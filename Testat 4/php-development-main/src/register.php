<!DOCTYPE html>

<?php

require('start.php');

$usernameWert = "";
$passwortWert = "";
$confpasswortWert = "";
$checksPassed = true;

if(isset($_POST['usrn']) && isset($_POST['pass']) && isset($_POST['confpass'])) {

    $usernameWert = $_POST['usrn'];
    $passwortWert = $_POST['pass'];
    $confpasswortWert = $_POST['confpass'];

    if(trim($usernameWert, ' ') == "" || strlen($usernameWert) < 3 ) {
        # Fehlermeldung
        echo "<script>alert('incorrect username')</script>";
        $checksPassed = false;
    }

    if($service->userExists($usernameWert)) {
       # Fehlermeldung
       echo "<script>alert('already existing user')</script>";
       $checksPassed = false;
    }

    if($passwortWert == "" || strlen($passwortWert) < 8) {
        # Fehlermeldung
        echo "<script>alert('incorrect password')</script>";
        $checksPassed = false;
    }

    if($passwortWert != $confpasswortWert) {
        # Fehlermeldung
        echo "<script>alert('unmatching passwords')</script>";
        $checksPassed = false;
    }

    if($checksPassed) {
        if($service->register($usernameWert, $passwortWert)) {
            $_SESSION["user"] = $usernameWert;
            header("Location: friends.php");
            exit();
        } else {
            echo "<script>alert('failed registry')</script>";
        }
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <meta name="viewport" content="width=device-width" >
        <script src="main.js"></script>
    </head>

    <body class="small">
        <div class="centered">
            <!--IMAGE-->
            <img class="centered" src="user.png" alt="register --image-">
        </div>
        
         <!--HEADER TITLE-->
        <h1 class="centered">Register yourself</h1>

        <!--REGISTER FORM-->
        <form id="register-form" action="register.php" method="post" onsubmit="return checkRegisterInput()">
            <fieldset class="inputs" class="smaller">
                <legend>Register</legend>
                
                <p>
                    <label class="col-1" for="username">Username</label>
                    <input class="col-2" id="username" name="usrn" type="text" placeholder="Username" value="<?= $usernameWert; ?>" required>
                </p>
                <p>
                    <label class="col-1" for="password">Password</label>
                    <input class="col-2" id="password" name="pass" type="password" placeholder="Password" value="<?= $passwortWert; ?>" required>
                </p>
                <p>
                    <label class="col-1" for="confirm password">Confirm Password</label>
                    <input class="col-2" id="confirm-password" name="confpass" type="password" placeholder="Confirm Password" value="<?= $confpasswortWert; ?>" required>
                </p>
            </fieldset>

            <!--Button mit link zum abbrechen-->
            <a href="login.php" target="_self" style="text-decoration: none;">
                <button  class="but-1" type="button">Cancel</button>
            </a>

            <!--Submit Button-->
            <button  class="but-2" id="submit" type="submit">Create Account</button> 
        </form>
        
    </body>
</html>