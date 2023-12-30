<?php
require("start.php");
if(isset($_SESSION["user"])){
    header("Location: friends.php");
    exit();  
}
if(isset($_POST['usrn'])&& isset($_POST['pass'])){
    if($service->login($_POST['usrn'],$_POST['pass'])){
        $_SESSION["user"]= $_POST['usrn'];
        header("Location: friends.php");
        exit();
    }else{
        $cMeldung = 'Falscher Username oder Falsches Passwort';
        echo '<script type="text/javascript">alert("'.$cMeldung.'");</script>';    
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" >
    <link rel="stylesheet" type="text/css" href="mystyle2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Log in</title>
</head>

<body class="bg-light small">

        <!--image-->
        <img class="rounded-circle mx-auto d-block mt-3 round" src="chat.png" alt="login --image-">
    <!--HEADER TITLE-->
    <div class="container container-sm ">
        <div class="card my-4 ">
            <div class="card-body my-4 mx-4">
                <h3 class="card-title text-center mb-3">Please sign in</h3>

    <!--LOGIN FORMULAR style="max-width: 500px; margin:auto;"-->
    <form  clas="was-validated " action="login.php" target="_self" id="login-form" method="post" > 
    <!--row1-->
    <div class="row mb-3 ">
        <div class="col-12">
            <div class="form-group">
                <input class="form-control p-3 " id="usernameInput" name="usrn" type="text" placeholder="Username" required>
            </div>
        </div>
    </div>
    <!--row2-->
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <input class="form-control p-3" id="passwordInput" name="pass" type="password" placeholder="Password" required>
            </div>
        </div>
    </div>
        <div id="message" class="error-message"></div>
    <!--row3 buttons-->
    <div class="row justify-content-center">
        <div class="col-12">
        <div class="btn-group w-100">
        <!--Button mit link zur Registrierung page-->
        <a href="register.php" target="_self" style="text-decoration: none;" class="but-1 btn btn-lg btn-secondary"> <!--link für das ziel-->Register                             <!--der Button-->
        </a>

        <!--Submit button, ziel ist das was in action-Attribut steht-->
        <button class="but-2 btn btn-lg btn-primary" id="submitb" type="submit" >Login</button>
        </div>
        </div>
    </div>
    </form>
    </div>
    </div>
    </div>

</body>

</html>







