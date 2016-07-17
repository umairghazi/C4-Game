<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/8/16
 * Time: 11:44 AM
 */


function returnJson ($stmt){
    $stmt->execute();
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $bindVarsArray = array();
    while ($column = $meta->fetch_field()) {
        $bindVarsArray[] = &$results[$column->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
    $data = array();
    while($stmt->fetch()) {
        $clone = array();
        foreach ($results as $k => $v) {
            $clone[$k] = $v;
        }
        $data[] = $clone;
    }
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-Type:text/plain");
    return json_encode($data);
}




function sanitizeString($string){
    $blackList = array("/`/","/'/","/</","/>/",'/"/', "/%/", "/\(/", "/\)/", "/\\\/", "/\//", "/\_/", "/\|/");
    $string = htmlentities($string);
    $string = strip_tags($string);
    $string = stripslashes($string);
    $string = preg_replace($blackList,"",$string);
    $string =  trim($string);
    return $string;
}


function createToken($username,$ip){
    $ip = explode(".",$ip);
    $ip = implode("",$ip);
    $time = time();
    $salt = "STRING";

    $token = $username | $ip;
    $token = $token & $salt;

    $token = base64_encode($token."|".$time);
    return $token;
}

function validateToken($username,$ip,$token){
    $ip = explode(".",$ip);
    $ip = implode("",$ip);
    $salt = "STRING";

    $gen_token = $username | $ip;
    $gen_token = $gen_token & $salt;
    $firstPartofToken = "";
    $tok_time = "";
    $token = base64_decode($token);
    list($firstPartofToken, $tok_time) = explode("|",$token);
    if($firstPartofToken == $gen_token){
        return true;
    } else{
        return false;
    }
}





?>