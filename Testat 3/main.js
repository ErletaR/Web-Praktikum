//window.backendURL = "https://online-lectures-cs.thi.de/chat/84da5540-a712-4b67-a700-3bbd5633100d";
window.backendURL = "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9";
//token für tom
//window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjk5OTc3NTM1fQ.q7Dhc-cVLgpgfc9RlyrZNXQE8skc9r4xIOFGwjHhNPY";
window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwMTIxODI0fQ.Q1zk9O-rIDPts-QhbNpN8ukWajWtUdRBwLt_Jw9MQdI"
//token für jerry
//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE2OTk5Nzc1MzV9.6dOl6Pa7aHtAjvCVwBcD1q1wNOHXKSgKk5lTiierjzs
var users = [];
var user = "Tom";
var friends = [];
window.setInterval(function () {
    friendupdate();
}, 1000);
/*
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
            console.log("Removed...");
        }
    };
    xmlhttp.open("DELETE", "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9/friend/Truck", true);
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
}




function initNames(prefix) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            users = data;
            const datalist = document.getElementById('friend-selector');

            datalist.innerHTML = '';
            /*
            while (datalist.firstChild) {
                datalist.removeChild(datalist.firstChild);
            }*/

            console.log(`datalist: ${datalist.children.length}`);

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
            console.log(users);
        }
    };
    // Chat Server URL und Collection ID als Teil der URL
    xmlhttp.open("GET", window.backendURL + "/user", true);
    // Das Token zur Authentifizierung, wenn notwendig
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + window.token);
    xmlhttp.send();


}

function keyup(input) {
    document.getElementById("friend-request-name").style.borderColor = "rgb(118, 118, 118)";
    getfriends();
    const text = input.value;
    initNames(text);
}

function checkForm() {
    const inputValue = document.querySelector('input[name="friendRequestName"]').value;

    if (inputValue != user && testsame(inputValue)) {


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

function testsame(inputValue) {
    for (var i = 0; i < friends.length; i++) {
        if (friends[i].username == inputValue) {
            return false;
        }
    }
    return true;
}


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
            a.setAttribute("href", "chat.html");
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