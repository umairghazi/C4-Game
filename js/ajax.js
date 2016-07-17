function ajaxCall(Type, data, callback) {
    $.ajax({
        type: Type,
        async: true,
        cache: false,
        url: "mid.php",
        data: data,
        dataType: "json",
        success: callback
    });
}


var playerId = "";

function initGame(whichMethod, value) {

    console.log("1. in initGame(). Data - " + whichMethod + " " + value);

    ajaxCall("GET", {method: whichMethod, a: "game", data: value}, startGameCallBack);
}

function startGameCallBack(jsonObj) {

    console.log("2. in startGameCallBack. Data - ");
    console.log(jsonObj);


    turn = jsonObj[0].whoseTurn;
    if (player == jsonObj[0].player1) {
        player2 = jsonObj[0].player0;
        playerId = 1;
    } else {
        player2 = jsonObj[0].player1;
        playerId = 0;
    }
    if (playerId == turn) {
        document.getElementById('output2').firstChild.nodeValue = 'Your Turn to play';
    } else {
        document.getElementById('output2').firstChild.nodeValue = 'Oppponent s turn to play';
    }
    gameInit();
}

function loginAjax(username, password) {
    ajaxCall("GET", {method: "checkLogin", a: "login", data: username + "|" + password}, loginCallback);
}
function registerAjax(username, password) {
    ajaxCall("GET", {method: "registerUser", a: "login", data: username + "|" + password}, registerCallback);
}

function makeUserActiveAjax(username) {
    ajaxCall("GET", {method: "makeUserActive", a: "login", data: username}, makeUserActiveCallback);
}

function logoffUserAjax(username) {
    ajaxCall("GET", {method: "logoffUser", a: "login", data: username}, logoffUserCallback);
}

function logoffUserCallback(jsonObj) {
    DeleteCookie("token");
    DeleteCookie("username");
    window.location = "login.php";
}

function changeBoardAjax(pieceId, boardI, boardJ, whatMethod, val) {
    ajaxCall("GET", {
        method: whatMethod,
        a: "game",
        data: val + "~" + pieceId + "~" + boardI + "~" + boardJ + "~" + playerId
    }, null);
}
function changeServerTurnAjax(whatMethod, val) {
    ajaxCall("GET", {method: whatMethod, a: "game", data: val}, null);
}

function checkTurnAjax(whatMethod, val) {


    console.log("4. in checkturnajax(). Data - "+ whatMethod +  " " + val);

    if (turn != playerId) {
        ajaxCall("GET", {method: whatMethod, a: "game", data: val}, callbackCheckTurn);
    }
    if (playerId == turn) {
        document.getElementById('output2').firstChild.nodeValue = "Your turn to play";
    } else {
        document.getElementById('output2').firstChild.nodeValue = "Opponent's turn to play";
    }
    timer = setTimeout("checkTurnAjax('checkTurn'," + gameId + ")", 3000); //setting a timer handle which i will use later to stop setTimeout when game is finished
}

function callbackCheckTurn(jsonObj) {


    console.log("5. in callbackCheckReturn(). Data - ");
    console.log(jsonObj);


    var status = parseInt(jsonObj[0].status);
    if (status > 2) {
        // setTimeout("gameOver(" + status + ")", 1000);
        gameOver(status);
    }
    if (jsonObj[0].whoseTurn == playerId) {
        console.log("jsonObj[0].whoseTurn" + jsonObj[0].whoseTurn);
        console.log("playerId" + playerId);

        turn = jsonObj[0].whoseTurn;
        getMoveAjax('getMove', gameId);
    }
}

function getMoveAjax(whatMethod, val) {
    console.log("6. in getMoveAjax. Data - " + whatMethod  + " "  + val);


    ajaxCall("GET", {method: whatMethod, a: "game", data: val}, callbackMove);
}

function callbackMove(jsonObj) {

    console.log("7 in callbackmove(). Data - ");
    console.log(jsonObj);


    for (var key in jsonObj) {
        if (boardArr[jsonObj[key].row][jsonObj[key].col].occupied == "") {
            pieceArr[0][pieceArr[0].length] = new Piece('game_' + gameId, jsonObj[key].player, jsonObj[key].row, jsonObj[key].col, 'Checker', pieceArr[0].length);

        }
    }
}
function endGameAjax(whatMethod, val) {
    ajaxCall("GET", {method: whatMethod, a: "game", data: val}, callbackMove);
}