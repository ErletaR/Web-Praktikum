<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
var_dump($_POST['action']);
require("start.php");

$friendList = $service->loadFriends();
$userList = $service ->loadUsers();
$service->removeFriend("hello");
var_dump($friendList);
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();  
}

if(isset($_POST['action'])){
    switch($_POST['action']){
        case "add-friend":
            processFriendRequest($friendList, $userList);
        case "remove-friend":
            processRemoveFriend();
        }
        if (substr($_POST['action'],0,13)=="accept-button"){
            processAcceptFriend();
        }
        if (substr($_POST['action'],0,13)=="reject-button"){
            processRejectFriend();
        }
}

function processFriendRequest($friendList, $userList) {
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    if(Userexists($_POST['friend'], $userList)){
        if ($_POST['friend'] != $_SESSION['user'] && !isUserInFriendlist($_POST['friend'], $friendList)) {
            $requested["username"]=$_POST['friend'];
            $requestedUser = new Model\Friend($_POST['friend']);
            if ($service->friendRequest($requestedUser->jsonSerialize())) {

            } 
            
        }else{
            Fehlermeldung("Der eingegebene name ist schon in deiner Freundesliste");
        }
       }else{
        Fehlermeldung("Der eingegebene Name existiert nicht");
       }    
}

function processAcceptFriend() {
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
        $service->friendAccept(substr($_POST['action'],13));
}

function processRejectFriend(){
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $service->friendDismiss(substr($_POST['action'],13));
}
// woher name 
function processRemoveFriend(){
    //if ($service->removeFriend("")) {header("Location: friendlist.php");}
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

<?php
$friendList = $service->loadFriends();
$userList = $service ->loadUsers();

// UserList Freunde raus Filtern und eingelogten user
$tempUserList=array();
foreach($userList as $user) {
    if (!($user == $_SESSION['user']) && !(isUserInFriendlist($user, $friendList))){
        $tempUserList[] = $user;
    }
}

function isUserInFriendlist($username, $friendList) {
    $result = false;
    foreach($friendList as $friend) {
        if ($friend->get_username() == $username) {
            $result = true;
            break;
        }
    }
    return $result;
}

function Userexists($username, $userl){
    foreach($userl as $user) {
        if($user==$username){
            $result=true;
            break;
        }
    }
    return $result;
}

function Fehlermeldung($Fehler){
    ?>
    <script>
    alert("<?php echo $Fehler ?>");
    </script>
    <?php
}
?>

<script>
setInterval(function() {
loadFriends();
}, 2000);


        var users =[];
        var friends = [];
        function keyup(input) {
            document.getElementById("friend-request-name").style.borderColor = "rgb(118, 118, 118)";
            const text = input.value;
            users = <?php echo json_encode($tempUserList) ?>;
            initNames(text);
        }
        function initNames(prefix) {
            const datalist = document.getElementById('friend-selector');
            datalist.innerHTML = '';
            for (let name of users) {
                if (prefix === '' || name.toLowerCase().startsWith(prefix) || name.startsWith(prefix)) {
                    const option = document.createElement('OPTION');
                    option.setAttribute('value', name);
                    datalist.appendChild(option);
                }}
            }
        function loadFriends(){
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "php/ajax_load_friends.php", false);
            xmlhttp.send();
            if (xmlhttp.responseText != "") {
                let friends = JSON.parse(xmlhttp.responseText);
                while (document.getElementById("friends").firstChild) {
        document.getElementById("friends").removeChild(document.getElementById("friends").firstChild);
    }
    while (document.getElementById("friendrequests").firstChild) {
        document.getElementById("friendrequests").removeChild(document.getElementById("friendrequests").firstChild);
    }
    for (var i = 0; i < friends.length; i++) {
        if (friends[i].status == "accepted") {
            let li = document.createElement("li");
            let div = document.createElement("div");
            let div2 = document.createElement("div");
            let a = document.createElement("a");
            div2.className = "bluebox";
            div.className = "container";
            a.innerText = friends[i].username;
            a.setAttribute("href", "chat.html?friend=" + friends[i].username);
            div2.innerHTML = friends[i].unread;
            document.getElementById("friends").appendChild(li);
            li.appendChild(div);
            div.appendChild(a);
            div.appendChild(div2);
        } else {
            let li2 = document.createElement("li");
            let but1 = document.createElement("button");
            let but2 = document.createElement("button");
            let b = document.createElement("b");
            li2.className = "col-1";
            but1.className = "but-1";
            but2.className = "but-2";
            but1.innerHTML = "Accept";
            but2.innerHTML = "Reject";
            but1.type = "submit";
            but2.type = "submit";
            li2.innerText = "Friend request from";
            b.innerText = friends[i].username;
            document.getElementById("friendrequests").appendChild(li2);
            li2.appendChild(b);
            li2.appendChild(but1);
            li2.appendChild(but2);
        }
    }

            }
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
        <?php
                    foreach($tempUserList as $user) {
                ?>
                <option value="<?= $user ?>"></option>
                <?php
                    }
                ?>
        </datalist>
        <button class="but-einzeln" type="submit" name= "action" value="add-friend">Add</button>
    </form>

</body>

</html>