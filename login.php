<html>

<head>
    <title>Login</title>

    <!--    Material Design Lite Script and Stylesheet-->
    <script src="js/material.js"></script>
    <link rel="stylesheet" href="css/material.min.css">

    <!--  Custom Stylesheet  -->
    <link rel="stylesheet" href="css/main.css">

    <!-- Javascript files    -->
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/login.js"></script>
    <script src="js/cookies.js"></script>
    <script src="js/ajax.js"></script>

</head>

<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Connect 4 - The Game</span>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <a class="mdl-navigation__link" href=""></a>
            </nav>
        </div>
    </header>


    <main class="mdl-layout__content">
        <div class="page-content">
            <h3 class="centered-text">Login to enter the lobby</h3>
            <form>
                <div class="form-container">
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="username" required/>
                        <label class="mdl-textfield__label" for="username">User Name...</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="password" id="password" required/>
                        <label class="mdl-textfield__label" for="password">Password...</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input type="button" name="submitLogin" value="Login" id="submitLogin"
                               class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"/>
                    </div>
                </div>
            </form>
            <div class="centered-text" id="alertMessage"></div>
            <p class="centered-text"><a href="register.php">or register as a new user</a></p>
        </div>
    </main>
</div>

<script>
    $(document).ready(function () {
        $("#username").focus();
        $("#submitLogin").on("click", loginUser);
    });
</script>
</body>


</html>