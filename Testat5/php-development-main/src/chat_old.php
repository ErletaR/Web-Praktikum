<?php

require("start.php");

if (isset($_SESSION['user']) && trim($_SESSION['user'], " ") != "" && isset($_SESSION["chat_token"])) {
    
    $user = $service->loadUser($_SESSION["user"]);

    if(!$user) {
        header("Location: login.php");
        exit();
    }
    
    if(isset($_GET['friend']) && trim($_GET['friend'], " ") != "") {
        $friend = $_GET['friend'];
    } else {
        header("Location: friends.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <meta name="viewport" content="width=device-width" >
        <script src="main.js"></script>
    </head>

    <body class="big">
        <script>
            window.setInterval(function () {
                loadchat();
                console.log("loading chat...");
            }, 1000);
        </script>
        
        <h1 id="title"></h1> 
        
        <!--LINKS-->
        <p>
            <a href="friends.php" target="_self">&lt; Back</a> |
            <a href="profile.php" target="_self">Profile</a> |
            <a class="remove" href="friends.php?action=remove-friend&friend=<?= $_GET['friend']; ?>" target="_self">Remove Friend</a>
        </p>

        <!--THE CHAT-->
        <div class="whitebox" id="chat">
            <div id="chatnachricht" class="container">
                <div>Tom: Hallo!</div>
                <div class="timestamp">19:43:01</div>
            </div>
            <div id="chatnachricht" class="container">
                <div>Jerry: Wie gehts!</div>
                <div class="timestamp">19:43:01</div>
            </div>
        </div>

        <!--FORM FOR NEW MESSAGES-->
        <p>
            <form class="fullline" action="chat.php" target="_self"> 
                <input class="col-2" name="new message" placeholder="New Message">
                <button class="but-einzeln" type="button" onclick="sendmessage()">Send</button>
            </form>
        </p>
       1 
    </body>
</html>