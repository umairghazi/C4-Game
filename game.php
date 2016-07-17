<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/10/16
 * Time: 1:02 AM
 */

session_start();
include "./bizLayer/utils.php";
if (!isset($_COOKIE['username']) || !isset($_COOKIE['token'])) {
    header("location:login.php");
}

if (!validateToken($_COOKIE['username'], $_SERVER['REMOTE_ADDR'], $_COOKIE['token'])) {
    header("location:login.php");
}
if (!isset($_GET['gameId']) || !isset($_GET['player'])) {
    header("location: lobby.php");
}
header('Content-type: application/xhtml+xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Game Play</title>


    <!--    Material Design Lite Script and Stylesheet-->
    <script src="js/material.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link rel="stylesheet" href="css/material.min.css"/>

    <!--  Custom Stylesheet  -->
    <link rel="stylesheet" href="css/main.css"/>

    <!--    Support for safari and firefox for polyfill-->
    <script src="js/dialog-polyfill.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css"/>

    <!--   Third party MDL jquery modal dialog because default dialog won't work with safari and firefox -->
    <script src="js/mdl-jquery-modal-dialog.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/mdl-jquery-modal-dialog.css"/>

    <!--  Custom Stylesheet  -->
    <link rel="stylesheet" href="css/gamePage.css" type="text/css"/>

    <!-- Javascript files    -->
    <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
    <script src="js/game.js" type="text/javascript"></script>
    <script src="js/ajax.js" type="text/javascript"></script>
    <script src="js/chat.js" type="text/javascript"></script>
    <script src="js/cookies.js" type="text/javascript"></script>
    <script src="js/Objects/Cell.js" type="text/javascript"></script>
    <script src="js/Objects/Piece.js" type="text/javascript"></script>
    <script type="text/javascript">
        <![CDATA[
        var gameId = <?php echo $_GET['gameId'] ?>;
        var player = GetCookie('username');
        var username = player;

        initGame('start', gameId);  //call to game init with gameId - gameID comes from php
        $(document).ready(function () {
            $("#newChatMessage").keypress(function (event) {
                if (event.which == 13) {
                    sendChat();
                }
            });
            $("#welcomeMessage").html("Welcome " + username);
            getChat();
        });
        ]]>
    </script>
</head>

<!-- Will logoff user if window closes or if user refreshes the page -->
<body onbeforeunload="logoffUserAjax(player);">

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Connect 4 - The Game</span>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"
                        id="logout" onclick="logoffUserAjax(username); this.disabled = true">
                    <i class="material-icons">exit_to_app</i>
                </button>
                <div class="mdl-tooltip" for="logout">
                    Logout
                </div>

            </nav>
        </div>
    </header>
    <span id="welcomeMessage"></span>

    <div id="main" class="mdl-grid">
        <div id="sidebar" class="mdl-cell mdl-cell--3-col">
            <h3>Chat Messages</h3>
            <div id="chatMessages"></div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="newChatMessage"/>
                <label class="mdl-textfield__label" for="newChatMessage">Text...</label>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"
                    id="send-chat" value="Send" onclick="sendChat();">
                <i class="material-icons">send</i>
            </button>
            <div class="mdl-tooltip" for="send-chat">
                Send Message
            </div>

        </div>


        <div id="game-area" class="mdl-cell mdl-cell--9-col">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 version="1.1" width="650px" height="620px">


                <rect x="0px" y="0px" width="100%" height="100%" id="background"/>

                <text x="270px" y="20px" id="nyt" fill="red" display="none">
                    NOT YOUR TURN!
                </text>
                <text x="270px" y="20px" id="nyp" fill="red" display="none">
                    NOT YOUR PIECE!
                </text>
                <text x="50px" y="20px" id="output2">
                </text>
            </svg>
        </div>
    </div>
</div>

</body>
</html>