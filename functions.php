<?php
//file name: functions.php
    
function connect()
{
    global $host;
    global $uname;
    global $pass;
    global $db;
    
    $con = mysql_connect($host,$uname,$pass);

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($db, $con);
}
    
function getRandomString($length)
{
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
    $validCharNumber = strlen($validCharacters);
    $result = "";
    
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
    return $result;
}
    
function getcurrentpath()
{
    $curPageURL = "";
    if ($_SERVER["HTTPS"] != "on")
        $curPageURL .= "http://";
    else
        $curPageURL .= "https://" ;
    if ($_SERVER["SERVER_PORT"] == "80")
        $curPageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    else
        $curPageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    $count = strlen(basename($curPageURL));
    $path = substr($curPageURL,0, -$count);
    return $path;
}
    
?>
