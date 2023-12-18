<?php
require("start.php");
session_unset();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Log out</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <meta name="viewport" content="width=device-width" >
        <script src="main.js"></script>
    </head>

    <body class="small">
        <div class="centered">
            <div>
                <!--image-->
                <img class="centered" src="logout.png" alt="logout --image-">
            </div>

            <!--HEADER TITLE-->
            <h1>Logged out...</h1>

            <p>See u!</p>

            <!--LINK ZU LOGIN-->
            <a href="login.php" target="_self">Login again</a>
        </div>
    </body>
</html>