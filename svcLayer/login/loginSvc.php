<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/8/16
 * Time: 12:27 PM
 */

require_once('meekrodb.2.3.class.php');
require_once('dbInfoPS.inc');
require_once('bizLayer/loginBiz.php');
require_once('bizLayer/utils.php');

function checkLogin($data,$ip,$token){
    list($username,$password) = explode("|",$data);
    return checkLoginBiz($username,$password);
}

function registerUser($data,$ip,$token){
    list($username,$password) = explode("|",$data);
    return registerUserBiz($username,$password);

}

function makeUserActive($data){
    return makeUserActiveBiz($data);
}

function logoffUser($data){
    return logoffUserBiz($data);
}