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
    
function newPasswordIsValid()
{
    global $new_password;
    global $new_password_confirm;
    global $alert;
    
    if($new_password!=$new_password_confirm)
    {
        $alert = "New password does not match..";
        return false;
    }
    
    if(strlen($new_password)<6)
    {
        $alert = "New password must contain at least 6 characters..";
        return false;
    }
    return true;
}
    
function newUsernameIsValid()
{
    global $new_user;
    global $new_user_confirm;
    global $alert;
    
    if($new_user!=$new_user_confirm)
    {
        $alert = "New username does not match..";
        return false;
    }
    
    if(strlen($new_user)<6)
    {
        $alert = "New username must be a valid email address..";
        return false;
    }
    return true;
}
    
?>
