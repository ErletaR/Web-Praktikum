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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Log in</title>
</head>

<body class="small">
    <div class= "container text-center">
        <!--image-->
        <img class="center image-border-circle mt-4 mb-4" src="chat.png" alt="login --image-">
    <!--HEADER TITLE-->
    <h1 class="centered">Please sign in</h1>

    <!--LOGIN FORMULAR-->
    <form action="login.php" target="_self" id="login-form" method="post" style="max-width: 500px; margin:auto;"> 
        <fieldset >                              
            <legend>Login</legend>
            
            <div class=" form-outline mb-3">
                <label class="col-1 sr-only" for="usernameInput">Username</label>
                <input class="col-2 form-control" id="usernameInput" name="usrn" type="text" placeholder="Username" required>
</div>
            <div class="form-outline mb-3">
                <label class="col-1" for="passwordInput">Password</label>
                <input class="col-2 form-control" id="passwordInput" name="pass" type="password" placeholder="Password" required>
</div>
        </fieldset>
        <div id="message" class="error-message"></div>
        <div class="btn-group">
        <!--Button mit link zur Registrierung page-->
        <a href="register.php" target="_self" style="text-decoration: none;"> <!--link für das ziel-->
            <button class="but-1 btn btn-lg btn-secondary" type="button">Register</button>                             <!--der Button-->
        </a>

        <!--Submit button, ziel ist das was in action-Attribut steht-->
        <button class="but-2 btn btn-lg btn-primary" id="submitb" type="submit" >Login</button>
</div>
    </form>
    </div>

</body>

</html>