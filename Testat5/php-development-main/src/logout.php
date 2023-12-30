<?php
require("start.php");
session_unset();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Log out</title>
        <link rel="stylesheet" type="text/css" href="mystyle2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width" >
        <script src="main.js"></script>
    </head>

    <body class="bg-light small">
        <img class="rounded-circle mx-auto d-block mt-3 round" src="logout.png" alt="logout --image-">
        <div class="container container-sm">
        <div class="card my-4 d-flex">
            <div class="card-body my-4 mx-4">
                <h3 class="card-title text-center">Logged out...</h3>
                <p class="text-center">See u!</p>
                <a class="btn btn-secondary w-100" href="login.php">Login again</a>
            </div>
        </div>
    </div>
    </body>
</html>