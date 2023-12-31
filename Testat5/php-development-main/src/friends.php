<?php

require("start.php");
$friendList = $service->loadFriends();
$userList = $service ->loadUsers();

$service->removeFriend("hello");
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();  
}

if(isset($_GET['action']) && $_GET['action'] == "remove-friend") {
    processRemoveFriend();
}


if(isset($_POST['action'])){
    switch($_POST['action']){
        case "add-friend":
            processFriendRequest($friendList, $userList);
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
    console.log("a");
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $service->friendAccept(substr($_POST['action'],13));
    
}

function processRejectFriend(){
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $service->friendDismiss(substr($_POST['action'],13));
}
// woher name 
function processRemoveFriend(){
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $friend = $_GET['friend'];
    var_dump($friend);
    if ($service->removeFriend($friend)) {
        header("Location: friends.php");
    exit();
    }
    
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Friends</title>
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" type="text/css" href="mystyle2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width">
</head>

<body class="bg-light big">

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
            xmlhttp.open("GET", "/ajax_load_friends.php", false);
            xmlhttp.send();
            if (xmlhttp.responseText != "") {
                let friends = JSON.parse(xmlhttp.responseText);
                while (document.getElementById("friends").firstChild) {
        document.getElementById("friends").removeChild(document.getElementById("friends").firstChild);
    }
    while (document.getElementById("friendrequests").firstChild) {
        document.getElementById("friendrequests").removeChild(document.getElementById("friendrequests").firstChild);
    }
    var count=0;
    for (var i = 0; i < friends.length; i++) {
        if (friends[i].status == "accepted") {
            count=1;
            let li = document.createElement("li");
            let div = document.createElement("div");
            let div2 = document.createElement("div");
            let div3 = document.createElement("div");
            let a = document.createElement("a");
            div.className = "d-flex flex-row";
            div2.className = "flex-fill";
            div3.className = "bg-primary px-2 text-white rounded-circle";
            a.className="link-dark";
            li.className="list-group-item ";
            a.innerText = friends[i].username;
            a.setAttribute("href", "chat.php?friend=" + friends[i].username);
            a.setAttribute("style","text-decoration: none;");
            div3.innerHTML = friends[i].unread;
            document.getElementById("friends").appendChild(li);
            li.appendChild(div);
            div.appendChild(div2);
            div2.appendChild(a);
            div.appendChild(div3);
        } else {
            let li2 = document.createElement("li");
            let but1 = document.createElement("button");
            li2.className = "list-group-item";
            li2.setAttribute("data-value", "value");
            but1.className = "btn btn-link button text-dark text-decoration-none font-weight-bold custom-btn";
            but1.innerHTML = friends[i].username;
            but1.setAttribute("data-value",friends[i].username);
            li2.innerText = "Friend request from ";
            document.getElementById("friendrequests").appendChild(li2);
            li2.appendChild(but1);
        }
    }
    if(count==0){
        let p = document.createElement("p");
        p.innerHTML = "noch keine Freunde "
        document.getElementById("friends").appendChild(p);
    }
}

        }

</script>
<div class="container">

    <h1 class= "my-3">Friends</h1>
    <!--LINKS TO LOGOUT AND SETTINGS-->
    <div class="btn-group mb-3">
            <a class="btn btn-secondary" href="logout.php">&lt; Logout</a>
            <a class="btn btn-secondary" href="settings.php">Settings</a>
    </div>
    <hr class="mb-4">

    <!--FRIENDSLIST-->
    <div class="content-group" id="liste">
            <div id="friend-list" class="list-group">
    <?php
    $friends = $service->loadFriends();
    $unread = $service->getUnread();
    $countfriends = 0;
    ?>
    <ul id="friends" class="list-group">
    <?php 
    foreach ($friends as $value) { 
        if($value->get_status()== "accepted"){
        $countfriends = 1;?>
        <li  class="list-group-item " >
        <div class="d-flex flex-row">
            <div class="flex-fill">
            <a class="link-dark" href = "chat.php?friend=<?=$value->get_username()?>" target="_self" style="text-decoration: none;">
            <?= $value->get_username() ?>
        </a>
        </div>

        <div class = "bg-primary px-2 text-white rounded-circle"><?= $unread->{$value->get_username()} ?></div>
        </div>
    </li>
        <?php } }
        if($countfriends== 0){?>
        <p> noch keine Freunde </p>
        <?php } ?>
    </ul>
        </div>
        </div>

    <hr class="my-4">

    <!--FRIEND REQUESTS-->
    <h3>New Requests</h3>
    <form method="post" action="friends.php" id= "requests">
    <ol id="friendrequests" class="list-group list-group-numbered">
    <?php 
    foreach ($friends as $value) { 
        if($value->get_status()== "requested"){?>
        <li class="list-group-item">
            Friend request from
            <but class= "btn btn-link button text-dark text-decoration-none font-weight-bold custom-btn" style="text-decoration-none" data-value= "<?= $value->get_username() ?>"> <?= $value->get_username() ?></but>
        </li>
        <?php }  } ?>
    </ol>
    </form>
    <hr class="my-4">

    <!--ADD NEW FRIENDS-->
    <form class="fullline" action="friends.php" target="_self" id="friendrequest" method="post">
    <div class="input-group">
        <input class="form-control" name="friend" placeholder="Add Friend to List" id="friend-request-name"
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
        <button class="btn btn-primary" type="submit" name= "action" value="add-friend">Add</button>
                </div>
    </form>

    <div class="modal" tabindex="-1" id="friendRequestModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="friendRequestModalLabel" >Request from</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" >
                    </button>
      </div>
      <div class="modal-body">
      Accept request?
      </div>
      <form method="post" action="friends.php" id= "requests">
      <div class="modal-footer">
      <button id= "reject"type="submit" class="btn btn-secondary" name="action" value="reject-button">Dismiss</button>
      <button id="accept" type="submit" class="btn btn-primary" name="action" value="accept-button">Accpet</button>
      </div>
        </form>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var modal = new bootstrap.Modal(document.getElementById('friendRequestModal'));
        const buttonContainer = document.getElementById("friendrequests");

function openModal(event) {
    event.preventDefault();
  if (event.target.classList.contains("button")) {
    const buttonValue = event.target.getAttribute("data-value");
    document.getElementById("friendRequestModalLabel").innerHTML = "Request From " + buttonValue;
    document.getElementById("reject").setAttribute("value","reject-button"+buttonValue);
    document.getElementById("accept").setAttribute("value","accept-button"+buttonValue);
    modal.show();
  }
}

buttonContainer.addEventListener("click", openModal);

    </script>

</body>

</html>