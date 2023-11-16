//window.backendURL = "https://online-lectures-cs.thi.de/chat/84da5540-a712-4b67-a700-3bbd5633100d";
window.backendURL= "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9";
//token für tom
//window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjk5OTc3NTM1fQ.q7Dhc-cVLgpgfc9RlyrZNXQE8skc9r4xIOFGwjHhNPY";
window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwMTIxODI0fQ.Q1zk9O-rIDPts-QhbNpN8ukWajWtUdRBwLt_Jw9MQdI"
//token für jerry
//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE2OTk5Nzc1MzV9.6dOl6Pa7aHtAjvCVwBcD1q1wNOHXKSgKk5lTiierjzs
var users=[];
var user= "Tom";
var friends = [];
window.setInterval(function() {
    friendupdate();
    }, 1000);

    const xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        friends = data;
        console.log(data);
    }
};
xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/4f9b8bf6-2349-44b0-9854-8bab2c105da9/friend", true);
xmlhttp.setRequestHeader('Content-type', 'application/json');
xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwMTIxODI0fQ.Q1zk9O-rIDPts-QhbNpN8ukWajWtUdRBwLt_Jw9MQdI');
xmlhttp.send();



function initNames(prefix) {
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        users=data;
        const datalist = document.getElementById('friend-selector');

        datalist.innerHTML = '';
        /*
        while (datalist.firstChild) {
            datalist.removeChild(datalist.firstChild);
        }*/
    
        console.log(`datalist: ${datalist.children.length}`);
    
        for (let name of users) {
            if (prefix === '' || name.toLowerCase().startsWith(prefix) || name.startsWith(prefix) ) {
                console.log('adding ' + name);
                const option = document.createElement('OPTION');
                option.setAttribute('value', name);
                datalist.appendChild(option);
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
    document.getElementById("friend-request-name").style.borderColor= "lightgrey";
    const text = input.value;
    initNames(text);
}

function checkForm(){
    const inputValue = document.querySelector('input[name="friendRequestName"]').value;

    if(inputValue!=user && testsame(inputValue)){
    document.getElementById('friendrequest').submit();
    /* 
    let xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
        console.log("Requested...");
    }
};
xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/4367170b-ef04-4a83-8440-3bdce3e2487c/friend", true);
xmlhttp.setRequestHeader('Content-type', 'application/json');
xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjI5ODkzNTkwfQ.MRSZeLY8YNGp1dBWoYLUXTfs4ci1v13TkhQmke2nfII');
let data = {
    username: inputvalue
};
let jsonString = JSON.stringify(data);
xmlhttp.send(jsonString);
    */
    }else{
        document.getElementById("friend-request-name").style.borderColor= "red";
    }
}

function testsame(inputValue){
    for(var i = 0;i<friends.length;i++){
        if(friends[i].username==inputValue){
            return false;
        }
    }
    return true;
}

function friendupdate(){
    for(var i = 0;i<friends.length;i++){
        if(friends[i].status=="accepted"){
            
        }
    } 
}