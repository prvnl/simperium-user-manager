<?php
//file resetpassword.php
include("settings.php");

echo '<html>
<head>
<title>Forgot Password - '.$appName.'</title>

<STYLE TYPE="text/css">
<!--
BODY
{
    font-family:helvetica;
    font-size:x-small;
}
-->
</STYLE>
</head>
<body>';
    
session_start();
$token=$_GET['token'];

connect();
if(!isset($_POST['password']))
{
    $q="select email from tokens where token='".$token."' and used=0";
    $r=mysql_query($q);
    if($row=mysql_fetch_array($r))
    {
        $_SESSION['email']=$row['email'];
    }
    else die("Invalid link or Password already changed");
}
    
$pass=$_POST['password'];
$email=$_SESSION['email'];
if(!isset($pass))
{
    echo '<form method="post">
    Please enter your new password.<br><br>
    Password: <input type="password" name="password" /> <input type="submit" value="Change Password">
    </form>';
}
if(isset($_POST['password'])&&isset($_SESSION['email']))
{
    if($_POST['password']!='')
    {
        $q="update tokens set used=1 where token='".$token."' and used=0";
        $r=mysql_query($q);
        
        if(mysql_affected_rows()==1)
        {
            $ch = curl_init("https://auth.simperium.com/1/".$app_id."/reset_password/");

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" .$email."&new_password=".$pass."");
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('X-Simperium-API-Key:'.$adminKey.''));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($ch);
            
            if($result === false)
            {
                echo 'Curl error: ' . curl_error($ch);
            }
            else
            {
                $jsonArray = json_decode($result);
                
                if($jsonArray->{'status'} === "success")
                {
                    echo "Password is changed successfully";
                }
                else
                {
                    print $result;
                }
                
            }
        }
        else
        {
            echo "Invalid link or Password already changed";
        }
    }
    else
    {
        echo "Please enter a password";
    }
    
}
echo '</body></html>';
?>