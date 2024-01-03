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
        <meta name="viewport" content="width=device-width">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="mystyle2.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="main.js"></script>
    </head>

    <body class="bg-light small">
        <!--image-->
        <img class="rounded-circle mx-auto d-block mt-3 round" src="user.png" alt="register --image-">
        
        <div class="container-reg container-sm">
            <div class="card my-3">
                <div class="card-body my-3 mx-3">
                    <h3 class="card-title text-center mb-3">Register yourself</h3>

                    <form class="has-validation" action="register.php" id="register-form" method="post" onsubmit="return checkRegisterInput()"> <!--target="_self"-->
                        <!--row1-->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control p-3" id="username" name="usrn" type="text" placeholder="Username" value="<?= $usernameWert; ?>" required>
                                </div>
                            </div>
                        </div>
                        <!--row2-->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control p-3" id="password" name="pass" type="password" placeholder="Password" value="<?= $passwortWert; ?>" required>
                                </div>
                            </div>
                        </div>
                        <!--row3-->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control p-3" id="confirm-password" name="confpass" type="password" placeholder="Confirm Password" value="<?= $confpasswortWert; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div id="message" class="error-message"></div>
                        <!--row4 buttons-->
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="btn-group w-100">
                                    <a href="login.php" target="_self" style="text-decoration: none;" class="but-1 btn btn-lg btn-secondary">Cancel
                                    </a>
                                    <button class="but-2 btn btn-lg btn-primary" id="submit" type="submit" >Create Account</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>