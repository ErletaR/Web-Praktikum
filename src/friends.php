<?php
var_dump($_POST);
require("start.php");
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();  
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Friends</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <meta name="viewport" content="width=device-width">
</head>

<body class="big">
    <script>
        function keyup(input) {
            document.getElementById("friend-request-name").style.borderColor = "rgb(118, 118, 118)";
            const text = input.value;
            initNames(text);
}
</script>
<?php
$users=$service->loadUsers();
var_dump($users);
?>
<script>
function initNames(prefix) {
    const datalist = document.getElementById('friend-selector');
    datalist.innerHTML = '';
    const option = document.createElement('OPTION');
    option.setAttribute('value', "test");
    datalist.appendChild(option);
}

    </script>
    <h1>Friends</h1>
    <!--LINKS TO LOGOUT AND SETTINGS-->
    <p>
        <a href="logout.php" target="_self">&lt; Logout</a> |

        <a href="settings.php" target="_self">Settings</a>
    </p>

    <hr>

    <!--FRIENDSLIST-->
    <?php
    $friends = $service->loadFriends();
    $unread = $service->getUnread();
    $countfriends = 0;
    ?>
    <ul id="friends" class="whitebox">
    <?php 
    foreach ($friends as $value) { 
        if($value->get_status()== "accepted"){
        $countfriends = 1;?>
        <li> <div class="container"><a href = "chat.php?friend=<?=$value->get_username()?>" target="_self">
            <?= $value->get_username() ?>
        </a>
        <div class="bluebox"><?= $unread->{$value->get_username()} ?></div>
    </div></li>
        <?php } }
        if($countfriends== 0){?>
        <p> noch keine Freunde </p>
        <?php } ?>
    </ul>
    <hr>

    <!--FRIEND REQUESTS-->
    <h3>New Requests</h3>
    <form method="post" action="friends.php" id= "requests">
    <ol id="friendrequests">
    <?php 
    foreach ($friends as $value) { 
        if($value->get_status()== "requested"){?>
        <li class="col-1">
            <b> <?= $value->get_username() ?></b>
            <button class="but-1" type="submit" name="action" value="accept-button<?= $value->get_username() ?>">Accept</button>
            <button class="but-2" type="submit" name="action" value="reject-button<?= $value->get_username() ?>">Reject</button>
        </li>
        <?php }  } ?>
    </ol>
    </form>
    <hr>

    <!--ADD NEW FRIENDS-->
    <form class="fullline" action="friends.php" target="_self" id="friendrequest" method="post">
        <input class="col-2" name="friend" placeholder="Add Friend to List" id="friend-request-name"
            list="friend-selector" onkeyup="keyup(this)">
        <datalist id="friend-selector">
            <option> rtest</option>
            <!-- weitere Einträge -->
        </datalist>
        <button class="but-einzeln" type="submit" name= "action" value="add-friend">Add</button>
    </form>

</body>

</html>