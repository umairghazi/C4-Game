<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/11/16
 * Time: 10:04 PM
 */


function startData($gameId)
{

    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT * FROM c4game WHERE gameId=?")) {
        $stmt->bind_param("i", $gameId);
        $data = returnJson($stmt);
        $mysqli->close();
        return $data;
    }

}

function checkTurnData($gameId)
{

    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT whoseTurn, status FROM c4game WHERE gameId=?")) {
        $stmt->bind_param("i", $gameId);
        $data = returnJson($stmt);
        $mysqli->close();
        return $data;
    }

}

function changeTurnData($gameId)
{

    global $mysqli;
    if ($stmt = $mysqli->prepare("UPDATE c4game SET whoseTurn='2' WHERE gameId=? AND whoseTurn='0'")) {
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->close();
    }
    if ($stmt = $mysqli->prepare("UPDATE c4game SET whoseTurn='0' WHERE gameId=? AND whoseTurn='1'")) {
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->close();
    }
    if ($stmt = $mysqli->prepare("UPDATE c4game SET whoseTurn='1' WHERE gameId=? AND whoseTurn='2'")) {
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}

function changeBoardData($gameId, $pieceId, $boardI, $boardJ, $playerId)
{


    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT pieceId FROM c4board WHERE gameId=? AND row=? AND col=?")) {
        $stmt->bind_param("iii", $gameId, $boardI, $boardJ);
        $stmt->bind_result($result);
        $stmt->execute();
        $stmt->fetch();
    }
    //check for result
    if ($result) { // if there is already a piece in that location, do not insert
    } else {
        $sql = "INSERT INTO c4board (gameId, row, col, player, pieceId) VALUES(?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("iiiss", $gameId, $boardI, $boardJ, $playerId, $pieceId);
            $stmt->execute();
            $stmt->close();
        }
    }


    if (checkForWin($gameId, $boardI, $boardJ, $playerId)) {
        gameOver($gameId, $playerId);
    }

    $mysqli->close();

}

function getMoveData($gameId)
{
    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT * FROM c4board WHERE gameId=?")) {
        //bind parameters for the markers (s - string, i - int, d - double, b - blob)
        $stmt->bind_param("i", $gameId);
        $data = returnJson($stmt);
        $mysqli->close();
        return $data;
    }

}

function checkForWin($gameId, $boardI, $boardJ, $playerId)
{
    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT row, col, player FROM c4board WHERE gameId=?")) {
        //bind parameters for the markers (s - string, i - int, d - double, b - blob)
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->bind_result($row, $col, $player);
        $board = array();

        for ($i = -1; $i < 10; $i++)
            for ($j = -1; $j < 10; $j++)
                $board[$i][$j] = 9; // some random number other that 0 or 1; 9 means the position is not taken

        //$data = array();
        // fill the occupied positions with the player ids
        while ($stmt->fetch()) {
            $board[$row][$col] = $player;
        }


//        printBoard($board);
        $count = 0;
        $isWin = false;
        $newRow = $boardI;
        $newCol = $boardJ;


        // check if makes 4 in the downward direction
        while (true) {
            if ($board[++$newRow][$newCol] == $playerId) {
//                echo "in downward loop";
//                echo "newRow - " . $newRow;
//                echo "newCol - " . $newCol;
//                echo "count - "  . $count;
//                echo "is win -- " . $isWin;
                if (++$count > 2) {
                    $isWin = true;
                    break;
                }
            } else {
                break;
            }
        }

        // check if makes 4 in the right direction
        $count = 0;
        $newRow = $boardI;
        $newCol = $boardJ;
        while (true) {
            if ($board[$newRow][++$newCol] == $playerId) {
//                echo "in right loop ";
//                echo "newRow - " . $newRow;
//                echo "newCol - " . $newCol;
//                echo "count - "  . $count;
                if (++$count > 2) {

                    $isWin = true;
                    break;
                }
            } else {
                break;
            }
        }

        // check if makes 4 in the left direction
        $count = 0;
        $newRow = $boardI;
        $newCol = $boardJ;
        while (true) {
            if ($board[$newRow][--$newCol] == $playerId) {
//                echo "in left loop ";
//                echo "newRow - " . $newRow;
//                echo "newCol - " . $newCol;
//                echo "count - "  . $count;


                if (++$count > 2) {
                    $isWin = true;
                    break;
                }
            } else {
                break;
            }
        }

        // check if makes 4 in the diagonal bottom Left direction
        $count = 0;
        $newRow = $boardI;
        $newCol = $boardJ;
        while (true) {
            if ($board[++$newRow][--$newCol] == $playerId) {
//                echo "in diagonal bottom left loop ";
//                echo "newRow - " . $newRow;
//                echo "newCol - " . $newCol;
//                echo "count - "  . $count;

                if (++$count > 2) {
                    $isWin = true;
                    break;
                }
            } else {
                break;
            }
        }

        // check if makes 4 in the diagonal bottom right direction
        $count = 0;
        $newRow = $boardI;
        $newCol = $boardJ;
        while (true) {
            if ($board[++$newRow][++$newCol] == $playerId) {
//                echo "in diagonal bottom right loop ";
//                echo "newRow - " . $newRow;
//                echo "newCol - " . $newCol;
//                echo "count - "  . $count;

                if (++$count > 2) {
                    $isWin = true;
                    break;
                }
            } else {
                break;
            }
        }
        return $isWin;
    }
}



function gameOver($gameId, $playerId)
{
    $playerId = $playerId+3;
    global $mysqli;
    if($stmt=$mysqli->prepare("UPDATE c4game SET status=? WHERE gameId=?")){
        $stmt->bind_param("ii",$playerId, $gameId);
        $stmt->execute();
        $stmt->close();
    }
}