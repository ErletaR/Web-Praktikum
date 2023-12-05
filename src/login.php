<?php
require("start.php");
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <meta name="viewport" content="width=device-width" >
    <script src="main.js"></script>
    <title>Log in</title>
</head>

<body class="small">
    <div class="centered">
        <!--image-->
        <img class="centered" src="chat.png" alt="login --image-">
    </div>
    <!--HEADER TITLE-->
    <h1 class="centered">Please sign in</h1>

    <!--LOGIN FORMULAR-->
    <form action="friends.html" target="_self" id="login-form" method="post"> 
        <fieldset  class="inputs" class="smaller">                              
            <legend>Login</legend>
            
            <p>
                <label class="col-1" for="usernameInput">Username</label>
                <input class="col-2" id="usernameInput" name="usrn" type="text" placeholder="Username" required>
            </p>
            <p>
                <label class="col-1" for="passwordInput">Password</label>
                <input class="col-2" id="passwordInput" name="pass" type="password" placeholder="Password" required>
            </p>
        </fieldset>
        <div id="message" class="error-message"></div>
        <!--Button mit link zur Registrierung page-->
        <a href="register.html" target="_self" style="text-decoration: none;"> <!--link für das ziel-->
            <button class="but-1" type="button">Register</button>                             <!--der Button-->
        </a>

        <!--Submit button, ziel ist das was in action-Attribut steht-->
        <button class="but-2" id="submitb" type="button" onclick="initLogin()">Login</button>
    </form>

</body>

</html>