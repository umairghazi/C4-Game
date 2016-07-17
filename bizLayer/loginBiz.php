<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/8/16
 * Time: 12:41 PM
 */

function checkLoginBiz($username, $password)
{
    $username = sanitizeString($username);
    $password = sanitizeString($password);
    $password = sha1($password);
    $retval['validUser'] = false;
    $retval['token'] = "";
    $retval['username'] = $username;

    $checkUser = DB::queryFirstRow("SELECT * FROM c4users WHERE Name = %s", $username);
    if (!$checkUser) {
        $retval['userExists'] = false;
        return json_encode($retval);
    }

    $result = DB::query("SELECT Name FROM c4users WHERE Name = %s AND Password = %s", $username, $password);
    if ($result) {
        $retval['validUser'] = true;
        $retval['token'] = createToken($username, $_SERVER["REMOTE_ADDR"]);
    }
    return json_encode($retval);
}


function registerUserBiz($username, $password)
{

    $retval['registerStatus'] = false;
    $retval['username'] = $username;
    $username = sanitizeString($username);
    $password = sanitizeString($password);
    $password = sha1($password);

    $result = DB::queryFirstRow("SELECT * FROM c4users WHERE Name = %s", $username);
    if ($result) {

        $retval['registerStatus'] = false;
        $retval['userExists'] = true;
        return json_encode($retval);
    }

    DB::insert('c4users', array(
        'Name' => $username,
        'Password' => $password,
        'Status' => 0
    ));

    if (DB::affectedRows() > 0) {
        $retval['registerStatus'] = true;
    }
    return json_encode($retval);
}


function makeUserActiveBiz($username)
{

    $result = DB::update('c4users', array('Status' => 1), "Name=%s", $username);
    clearOldChat();
    $retval['updateStatus'] = $result;
    return json_encode($retval);

}

function clearOldChat()
{

    $seconds = 60 * 60;
    $cutoff = time() - $seconds;
    $cutoff = date("Y-m-d H:i:s", $cutoff);

    $oldChat = DB::query("SELECT * FROM c4chat");
    $line = "";
    for ($i = 0; $i < count($oldChat); $i++) {
        $line .= $oldChat[$i]["id"] . "|" . $oldChat[$i]["userId"] . "|" . $oldChat[$i]["message"] . "|" . $oldChat[$i]["timestamp"] . "|" . $oldChat[$i]["gameId"] . "\r\n";
    }
    $file = 'chatLog.txt';
    $current = file_get_contents($file);
    $current .= $line . "\r\n";
    file_put_contents($file, $current);

    $delChat = DB::delete('c4chat', "timestamp < %s", $cutoff);

}

function logoffUserBiz($username)
{

    $listOfGames = array();
    $update = DB::update('c4users', array('status' => 0), 'Name=%s', $username);

    $results = DB::query("SELECT gameId FROM c4game WHERE (status = 1 OR status = 0) AND (player1 = %s OR player2 = %s)", $username, $username);
    foreach ($results as $result) {
        $listOfGames[] = $result["gameId"];
    }
    foreach ($listOfGames as $listOfGame) {
        endGameBiz($listOfGame);
    }

    return $update;

}

function endGameBiz($gameId)
{
    $status = 5;
    $update = DB::update('c4game', array('status' => $status), "gameId=%s", $gameId);
    $delete = DB::delete('c4board', 'gameId=%s', $gameId);

}