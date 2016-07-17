<?php
/**
 * Created by IntelliJ IDEA.
 * User: umairghazi
 * Date: 1/11/16
 * Time: 10:00 PM
 */

require_once('meekrodb.2.3.class.php');
require_once('dbInfoPS.inc');
require_once('bizLayer/gameBiz.php');
require_once('bizLayer/utils.php');


function start($d)
{
    return startData($d); //returns game data
}

function changeTurn($d)
{
    changeTurnData($d);
}

function checkTurn($d)
{
    return checkTurnData($d);
}

function changeBoard($d)
{
    $h = explode("~", $d);
    changeBoardData($h[0], $h[2], $h[2], $h[3], $h[4]);
}

function getMove($d)
{
    return getMoveData($d);
}

?>