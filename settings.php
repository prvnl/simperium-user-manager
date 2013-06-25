<?php
//file name: settings.php

//General Settings
$appName="YourAppName"; //Your App Name
$emailFromName="AppName Support"; //Email from name
$emailFrom="support@appname.com"; //Email from address
$emailCC="support@appname.com"; //Email bcc address
    
//Simperium Settings
$app_id="YourAppID"; //Simperium App ID, found in Simperium dashboard
$apiKey="YourAPIKey"; //Simperium API Key, found in Simperium dashboard
$adminKey="YourAdminKey"; //Simperium Admin Key, found in Simperium dashboard
    
function connect()
{
    //MySQL database Settings
    $host="localhost"; //MySQL Host
    $uname="DatabaseUsername";  //Username for access to database
    $pass="DatabasePassword";      //Password for access to database
    $db= "DatabaseName";  //Database name
    
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
    return $path ;
}
?>