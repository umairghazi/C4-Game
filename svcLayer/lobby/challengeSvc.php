<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/9/16
 * Time: 9:07 PM
 */

require_once('meekrodb.2.3.class.php');
require_once('dbInfoPS.inc');
require_once('bizLayer/lobbyBiz.php');
require_once('bizLayer/utils.php');


function challengePlayer($data,$ip,$token){
    list($player1,$player2) = explode("|",$data);
    return challengePlayerBiz($player1,$player2);
}

function checkChallenges($data,$ip,$token){
    return checkChallengesBiz($data);
}

function acceptChallenge($d,$ip,$token){
    list($username,$gameId) = explode("|",$d);
    return acceptChallengeBiz($username,$gameId);
}

function rejectChallenge($d,$ip,$token){
    list($username,$gameId) = explode("|",$d);
    return rejectChallengeBiz($username,$gameId);
}