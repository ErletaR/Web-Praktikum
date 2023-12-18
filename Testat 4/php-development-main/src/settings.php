<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Settings</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <meta name="viewport" content="width=device-width" >
        <script src="main.js"></script>
    </head>

    <body class="big">
        <h1>Profile Settings</h1>
        <form action="settings.html" target="_self"> 
            <!--BASE DATA-->
                <!--tbd: wie und wo speichern wir die Daten die hier eingegeben werden-->
           <p>
            <fieldset class="inputs">
                <legend>Base Data</legend>
                <p>
                    <label class="col-1" for="first name">First Name</label>
                    <input class="col-2" id="first name" name="name" placeholder="Your name">
                </p>
                <p>
                    <label class="col-1" for="last name">Last Name</label>
                    <input class="col-2" id="last name" name="surname" placeholder="Your surname">
                </p>

                <label class="col-1" for="drink">Coffee or Tea?</label>
                <select class="col-2" id="drink" name="drink">
                    <option value="c">Coffee</option>
                    <option value="t">Tea</option>
                    <option value="n" selected>Neither nor</option>
                </select>
            </fieldset>
           </p> 
           

            <!--SMTH ABOUT THE USER-->
                <!--tbd: wie und wo werden die daten gespeichert?-->
                <!--nachdem sie eingegeben wurden, werde sie im Textfeld gespeichert bleiben-->
            <p>
                <fieldset>
                    <legend>Tell Something About You</legend>
                    <textarea id="smth" name="aboutMe" placeholder="Leave a comment here"></textarea>
                </fieldset>
            </p>
            

            <!-- CHOOSE CHAT LAYOUT-->
            <p>
                <fieldset class="radio">
                    <legend>Prefered Chat Layout</legend>
                    <p>
                        <input type="radio" id="chat-inOne" name="chat" value="inOne">
                        <label class="radio" for="chat-inOne">Username and message in one line</label>
                    </p>
                    <p>
                        <input type="radio" id="chat-inSep" name="chat" value="inSep"> <!--tbd:wie wird das chat-layout geändert?-->
                        <label class="radio" for="chat-inSep">Username and message in separated lines</label>
                    </p>
                    
                </fieldset>
            </p>
           

            <!--BUTTONS-->
            <!--Button mit link zur friends-->
            <a href="friends.html" target="_self" style="text-decoration: none;">
                <button class="but-1" type="button">Cancel</button>
            </a>
            <!--Submit button-->
            <button class="but-2" id="submit" type="submit">Save</button>
        </form>
    </body>
</html>