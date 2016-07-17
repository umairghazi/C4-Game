<?php

session_start();
include "./bizLayer/utils.php";
if (!isset($_COOKIE['username']) || !isset($_COOKIE['token'])) {
    header("location:login.php");
}

if (!validateToken($_COOKIE['username'], $_SERVER['REMOTE_ADDR'], $_COOKIE['token'])) {
    header("location:login.php");
}
?>

<html>

<head>
    <title>Game Lobby</title>


    <!--    Material Design Lite Script and Stylesheet-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="js/material.js"></script>
    <link rel="stylesheet" href="css/material.min.css">

    <!--  Custom Stylesheet  -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/lobby.css">

    <!--    Support for safari for polyfill required for MDL dialog-->
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css">

    <!--   Third party MDL jquery modal dialog because default dialog won't work with safari and firefox -->
    <script src="js/mdl-jquery-modal-dialog.js"></script>
    <link rel="stylesheet" href="css/mdl-jquery-modal-dialog.css">

    <!-- Javascript files    -->
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/lobby.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/game.js"></script>
    <script src="js/cookies.js"></script>
    <script>
        var username = GetCookie('username');
        var gameId = 0;

        $(document).ready(function () {
            getChat();
            getOnlineUsers();
            checkForChallenge();
            $("#welcomeMessage").html("Welcome to the game lobby " + username);
            $("#newChatMessage").keypress(function (event) {
                if (event.which == 13) {
                    sendChat();
                }
            });

        });
    </script>
</head>

<body>


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
            <h3>Online Players</h3>
            <div id="userList"></div>
        </div>
        <div id="chat-area" class="mdl-cell mdl-cell--9-col">
            <h3>Lobby Messages</h3>
            <div id="chatMessages"></div>
            <div id="chatBox">
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
        </div>
    </div>
</div>


</body>
</html>
