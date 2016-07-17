<?php

require_once "meekrodb.2.3.class.php";

$oldChat = DB::query("SELECT * FROM c4chat");
$line = "";
for ($i = 0; $i < count($oldChat); $i++) {
    $line .= $oldChat[$i]["id"] . "|" . $oldChat[$i]["userId"] . "|" . $oldChat[$i]["message"] . "|" . $oldChat[$i]["timestamp"] . "|" . $oldChat[$i]["gameId"] . "\r\n";
}


//$chatArchive = fopen("chatLog.txt", "a") or die("Unable to open file!");
//var_dump($chatArchive);


