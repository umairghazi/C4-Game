<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/9/16
 * Time: 1:26 PM
 */

require_once('meekrodb.2.3.class.php');
require_once('dbInfoPS.inc');
require_once('bizLayer/lobbyBiz.php');
require_once('bizLayer/utils.php');


function getChat($data,$ip,$token){
    return getChatData($data);
}

function sendChat($data,$ip,$token){
    list($username,$message,$gameId) = explode("|",$data);
    $message = sanitizeString($message);
    if($message != ''){
        addChatData($username,$message,$gameId);
    }
}

function getOnlineUsers($data,$ip,$token){
    return getLoggedInUsers($data);
}
?>