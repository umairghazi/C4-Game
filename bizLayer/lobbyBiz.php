<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/9/16
 * Time: 1:27 PM
 */


function getChatData($gameId)
{

    $returnJson = "";
    $retArr = array();
    $chatArr = array();
    $results = DB::query("SELECT userId, message, timestamp FROM c4chat WHERE gameId= %i ORDER BY timestamp",$gameId);
    foreach($results as $result) {
        $chatArr['name'] = $result['userId'];
        $chatArr['message'] = $result['message'];
        $timeStamp = $result['timestamp'];
        $tStamp = strtotime($timeStamp);
        $chatArr['timeStamp'] = date("h:i a", $tStamp);
        $retArr[] = $chatArr;
    }
    $returnJson = json_encode($retArr);
    return $returnJson;
}

function addChatData($username, $message, $gameId)
{
    DB::insert('c4chat',array(
        'userId'    => $username,
        'message'   => $message,
        'timestamp' => DB::sqlEval("CURRENT_TIMESTAMP"),
        'gameId'    => $gameId
    ));

    if(DB::affectedRows() > 0){
        return DB::affectedRows();
    }
    return false;

}

function getLoggedInUsers($data)
{

    $retval = "";
    $retArr = array();
    $results = DB::query("SELECT id, name, status FROM c4users WHERE status = 1 AND Name <> %s",$data);
    foreach($results as $result){
        $retval['name']   = $result['name'];
        $retval['status'] = $result['status'];
        $retArr[] = $retval;
    }
    $returnJson = json_encode($retArr);
    return $returnJson;

}


function challengePlayerBiz($player1, $player2)
{
    $retVal['gameId'] = 0;
    $turn = 0;
    $status = 0;
    DB::insert('c4game',array(
        'player1'  => $player1,
        'player2'  => $player2,
        'whoseTurn'=> $turn,
        'status'   => $status
    ));
    $retVal['gameId'] = DB::insertId();
    return json_encode($retVal);
}

function checkChallengesBiz($data)
{
    $challengeDetails['gameId'] = 0;
    $results = DB::query("SELECT gameId, player1 FROM c4game WHERE status = 0 AND player2 = %s",$data);

    foreach($results as $result){
        $challengeDetails['gameId'] = $result['gameId'];
        $challengeDetails['player1'] = $result['player1'];
    }
    return json_encode($challengeDetails);

    // statuses as saved in database
    // 0 = new challengeDetails
    // 1 = challenge accepted
    // -1 = challenge rejected
    // 3 = game won by player 1
    // 4 = game won by player 2
}

function acceptChallengeBiz($username, $gameId)
{
    $retVal['gameId'] = 0;

    $result = DB::update('c4game', array('status' => 1), 'gameId=%s AND player2=%s', $gameId, $username);
    $retVal['gameId'] = $gameId;
    return json_encode($retVal);
}


function rejectChallengeBiz($username, $gameId)
{
    $retVal['gameId'] = 0;
    $result = DB::update('c4game', array('status' => -1), 'gameId=%s AND player2=%s', $gameId, $username);

    $retVal['gameId'] = -1;
    return json_encode($retVal);
    
}