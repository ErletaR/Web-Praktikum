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
        <meta name="viewport" content="width=device-width">
        <title>Chat</title>
        <link rel="stylesheet" type="text/css" href="mystyle2.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    </head>

    <body class="bg-light d-flex align-items-center justify-content-center chat-big my-3">
        <script>
            window.setInterval(function () {
                loadchat();
                console.log("loading chat...");
            }, 1000);
        </script>
        
        <div class="container-chat container-sm">
            <h1 id="title"></h1> 
            
            <div class="btn-group w-50 mt-2">
                <a href="friends.php" target="_self" class="but-1 btn btn-secondary">Back</a>
                <a href="profile.php" target="_self" class="but-2 btn btn-secondary">Profile</a>
                <button type="button" class="but-3 btn btn-primary btn-danger" data-toggle="modal" data-target="#rm">Remove Friend</button>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="rm" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeModalLabel">Remove <?= $_GET['friend']; ?> as Friend</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Do you really want to end your friendship?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="friends.php?action=remove-friend&friend=<?= $_GET['friend']; ?>" target="_self" class="btn btn-primary">Yes, Please!</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--THE CHAT-->
            <div class="container-chat">
                <div class="card my-3">
                    <div class="card-body mx-0 px-0">
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
                    </div>
                </div>
            </div>
                
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="new message" placeholder="New Message" aria-label="New Message" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="button" id="button-addon2" onclick="sendmessage()">Send</button>
            </div>
        </div>
    </body>
</html>