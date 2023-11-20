//window.backendURL = "https://online-lectures-cs.thi.de/chat/84da5540-a712-4b67-a700-3bbd5633100d";
window.backendURL = "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9";
//token für tom
//window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjk5OTc3NTM1fQ.q7Dhc-cVLgpgfc9RlyrZNXQE8skc9r4xIOFGwjHhNPY";
window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwMTIxODI0fQ.Q1zk9O-rIDPts-QhbNpN8ukWajWtUdRBwLt_Jw9MQdI"
//token für jerry
//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE2OTk5Nzc1MzV9.6dOl6Pa7aHtAjvCVwBcD1q1wNOHXKSgKk5lTiierjzs

//window.token =localStorage.token;
var users = [];
var user = "Tom";
var friends = [];
var messages = [];
getusers();
listmessages();
/* Freunde löschen 

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
            console.log("Removed...");
        }
    };
    xmlhttp.open("DELETE", "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9/friend/t", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
    xmlhttp.send();
*/


function getfriends() {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            friends = data;
            console.log(data);
        }
    };
    xmlhttp.open("GET", window.backendURL + "/friend", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
    xmlhttp.send();

    return friends;
}

function getusers(){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            users = data;
            console.log(data);
        }
    };
    xmlhttp.open("GET", window.backendURL + "/user", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
    xmlhttp.send();

    return users;
}

function userExists(user) {

    let returnVal = false;

    const requestUrl = window.backendURL;

    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if(xmlhttp.status == 204) {
                console.log('User exists');
                returnVal = true;
            } else if(xmlhttp.status == 404) {
                console.log('User does not exist');
                returnVal = false;
            }
        }
    };
    
    xmlhttp.open("GET", requestUrl + "/user/" + user, false);
    xmlhttp.send();

    return returnVal;
}

// datalist befüllen
function initNames(prefix) {
    const datalist = document.getElementById('friend-selector');
    datalist.innerHTML = '';
    for (let name of users) {
        if (prefix === '' || name.toLowerCase().startsWith(prefix) || name.startsWith(prefix)) {
            if (name != user && testsame(name)) {
                console.log('adding ' + name);
                const option = document.createElement('OPTION');
                option.setAttribute('value', name);
                datalist.appendChild(option);
            }
        }
    }
}

// auf eingabe reagieren
function keyup(input) {
    getusers();
    getfriends();
    document.getElementById("friend-request-name").style.borderColor = "rgb(118, 118, 118)";
    const text = input.value;
    initNames(text);
}

// formular kontrollieren
function checkForm() {
    
    if (inputValue != user && testsame(inputValue) && users.includes(inputValue)) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
                console.log("Requested...");
                document.getElementById('friendrequest').submit();
            }
        };
        xmlhttp.open("POST", window.backendURL + "/friend", true);
        xmlhttp.setRequestHeader('Content-type', 'application/json');
        xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
        let data = {
            username: inputValue
        };
        let jsonString = JSON.stringify(data);
        xmlhttp.send(jsonString);

    } else {
        document.getElementById("friend-request-name").style.borderColor = "red";
    }
}
// Testen ob name schon in Freundesliste ist
function testsame(inputValue) {
    for (var i = 0; i < friends.length; i++) {
        if (friends[i].username == inputValue) {
            return false;
        }
    }
    return true;
}

// Freundesliste updaten
function friendupdate() {
    getfriends();
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
            but1.type = "button"
            li2.innerText = "Friend request from";
            b.innerText = friends[i].username;
            document.getElementById("friendrequests").appendChild(li2);
            li2.appendChild(b);
            li2.appendChild(but1);
            li2.appendChild(but2);
        }
    }
}

//REGISTER

function checkRegisterInput() {
    
    let returnVal = true;

    let users = getusers();

    const usernameInput = document.querySelector('#username');
    const passwordInput = document.querySelector('#password');
    const confirmPasswordInput = document.querySelector('#confirm-password');

    if(usernameInput.value.length < 3 ){
        alert('The username needs to have at least 3 charakters or longer!');
        usernameInput.style.borderColor = "red";
        returnVal = false;
    } else {
        usernameInput.style.borderColor = "green";
    }

    if(passwordInput.value.length < 8 ){
        alert('The password needs to have at least 8 charakters or longer!');
        passwordInput.style.borderColor = "red";
        returnVal = false;
    } else {
        passwordInput.style.borderColor = "green";
    }

    if(passwordInput.value !== confirmPasswordInput.value){
        alert('The password confirmation does not match!');
        confirmPasswordInput.style.borderColor = "red";
        returnVal = false;
    } else {
        confirmPasswordInput.style.borderColor = "green";
    }

    if(userExists(usernameInput.value)) {
        alert('User already exists!');
        usernameInput.style.borderColor = "red";
        returnVal = false;
    } else {
        if(usernameInput.style.borderColor !== "red") {
            usernameInput.style.borderColor = "green";
        }
    }

    // alternative method to check for user existence
    /*users.forEach(user => {
         if(user === usernameInput.value) {
            alert('User already exists!');
            returnVal = false;
         }
    });*/

    return returnVal;
}

//chat

function getChatpartner() {
    const url = new URL(window.location.href);
    // Access the query parameters using searchParams
    const queryParams = url.searchParams;
    // Retrieve the value of the "friend" parameter
    const friendValue = queryParams.get("friend");
    console.log("Friend:", friendValue);
    return friendValue;
    }

    function listmessages(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                let data = JSON.parse(xmlhttp.responseText);
                messages = data;
                console.log(data);
            }
        };
        xmlhttp.open("GET",  window.backendURL +"/message"  + "/" + getChatpartner(), true);
        xmlhttp.setRequestHeader('Authorization',  'Bearer ' + window.token);
        xmlhttp.send();

    }

    function loadchat(){
         listmessages();
        document.getElementById("title").innerHTML = "Chat with " + getChatpartner();
        document.getElementById("chat").innerHTML="";
        for(var i = 0; i < messages.length; i++){
            let div = document.createElement("div");
            let div2 = document.createElement("div");
            let div3 = document.createElement("div");
            div.className="container";
            div.id= "chatnachricht";
            div3.className= "timestamp";
            div2.innerHTML=  messages[i].from + ": " + messages[i].msg;
            var time = new Date(messages[i].time)
            div3.innerText = time.getHours() + ":" + time.getMinutes()  + ":" + time.getSeconds();
            document.getElementById("chat").appendChild(div);
            div.appendChild(div2);
            div.appendChild(div3);
        }
    }

    function sendmessage(){
        const inputValue = document.querySelector('input[name="new message"]').value;
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
                console.log("done...");
            }
        };
        xmlhttp.open("POST", window.backendURL + "/message", true);
        xmlhttp.setRequestHeader('Content-type', 'application/json');
        xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
        let data = {
            message: inputValue,
            to: getChatpartner()
        };
        let jsonString = JSON.stringify(data);
        xmlhttp.send(jsonString);

    }

    //login
    function initLogin() {
       
            const username = document.getElementById('usernameInput').value;
            const password = document.getElementById('passwordInput').value;
            user = username;
            login(username, password);
    }
    
    function login(uname, pwd) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4) {
                if (xmlhttp.status == 200) {
                    let data = JSON.parse(xmlhttp.responseText);
                    console.log("Token: " + data.token);
                     localStorage.token = data.token;
                     document.getElementById('login-form').submit();
                  } else {
                      document.getElementById('message').innerHTML = 'Invalid username/password combination!';
                  }
            }
        };
        xmlhttp.open("POST", window.backendUrl + "/login", true); 
        xmlhttp.setRequestHeader('Content-type', 'application/json');
        let data = {
            username: uname,
            password: pwd
        };
        let jsonString = JSON.stringify(data); // Serialize as JSON
        xmlhttp.send(jsonString);
    }