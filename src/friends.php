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