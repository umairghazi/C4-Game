var xhtmlns = "http://www.w3.org/1999/xhtml";
var svgns = "http://www.w3.org/2000/svg";
var BOARDX = 50;
var BOARDY = 50;
var boardArr = new Array();
var pieceArr = new Array();
var BOARDWIDTH = 8;
var BOARDHEIGHT = 8;
var CELLSIZE = 75;

var turn = "";


function gameInit() { 
    
    var gEle = document.createElementNS(svgns, 'g');
    gEle.setAttributeNS(null, 'transform', 'translate(' + BOARDX + ',' + BOARDY + ')');
    gEle.setAttributeNS(null, 'id', 'game_' + gameId);

    document.getElementsByTagName('svg')[0].insertBefore(gEle, document.getElementsByTagName('svg')[0].childNodes[5]);


    for (i = 0; i < BOARDWIDTH; i++) {
        boardArr[i] = new Array();
        for (j = 0; j < BOARDHEIGHT; j++) {
            boardArr[i][j] = new Cell(document.getElementById('game_' + gameId), 'cell_' + j + i, CELLSIZE, j, i);
        }
    }

    pieceArr[0] = new Array();
    
    console.log("3. in gameInit()");
    checkTurnAjax('checkTurn', gameId);
}


function changeTurn() {
    if (turn == 0) {
        turn = 1;
    } else {
        turn = 0;
    }
    changeServerTurnAjax('changeTurn', gameId);
}

function nytwarning() {
    if (document.getElementById('nyt').getAttributeNS(null, 'display') == 'none') {
        document.getElementById('nyt').setAttributeNS(null, 'display', 'inline');
        setTimeout('nytwarning()', 2000);
    } else {
        document.getElementById('nyt').setAttributeNS(null, 'display', 'none');
    }
}
function nypwarning() {
    if (document.getElementById('nyp').getAttributeNS(null, 'display') == 'none') {
        document.getElementById('nyp').setAttributeNS(null, 'display', 'inline');
        setTimeout('nypwarning()', 2000);
    } else {
        document.getElementById('nyp').setAttributeNS(null, 'display', 'none');
    }
}

function dropCheck(col) {
    var hit = "";
    if (turn == playerId) {
        hit = dropPiece(col);
    } else {
        hit = false;
        nytwarning();
    }
    if (hit == true) {

    } else {

    }
}

function dropPiece(col) {
    var height = BOARDHEIGHT - 1;
    while (height >= 0) {
        if (boardArr[height][col].occupied != '') {
            height--;
        }
        else {
            break;
        }
    }

    if (height >= 0) {
        pieceArr[0][pieceArr[0].length] = new Piece('game_' + gameId, playerId, height, col, 'Checker', pieceArr[0].length);
        changeBoardAjax(pieceArr[0][pieceArr[0].length - 1].id, pieceArr[0][pieceArr[0].length - 1].currentCell.row, pieceArr[0][pieceArr[0].length - 1].currentCell.col, 'changeBoard', gameId);
        changeTurn();
        return true;
    }
    return false;
}

function gameOver(status) {
    if (status == 5) {

        showDialog({
            title: 'Opponent Left!',
            text: 'Your opponent has left the match',
            positive: {
                title: 'Ok',
                onClick: function (e) {
                    window.location = "lobby.php";
                }
            }
        });
    } else {
        if ((status - playerId) == 3) {
            showDialog({
                title: 'CONGRATS!',
                text: 'You have won the match',
                positive: {
                    title: 'Go to lobby!',
                    onClick: function (e) {
                        window.location = "lobby.php";
                    }
                }
            });
            clearTimeout(timer); //stopping the setTimeout once the game has been finished

        } else {
            showDialog({
                title: 'Lost!',
                text: 'You have lost the match',

                positive: {
                    title: 'Ok',
                    onClick: function (e) {
                        window.location = "lobby.php";
                    }
                }
            });
        }
    }
}