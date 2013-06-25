<?php
//file name: forgotpassword.php
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

if(!isset($_GET['email']))
{
	echo'<form action="forgotpassword.php">
	Please enter the email address you signed up with to receive a password reset request.<br><br>
    Email address: <input type="text" name="email" /> <input type="submit" value="Reset my password" />
    </form>';
}
else
{
    $email=$_GET['email'];
    
    $ch = curl_init("https://auth.simperium.com/1/".$app_id."/authorize/");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" .$email."&password=test12345678");
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('X-Simperium-API-Key:'.$apiKey.''));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $result = curl_exec($ch);
    
    //We expect the result 'invalid password' because of fake password, if the result is different the user does not exists!!
    if($result != "invalid password")
    {
        //User account does not exist
        echo 'User account does not exist';
    }
    else
    {
        //User account exists
        $token=getRandomString(10);

        connect();
        $q="insert into tokens (token,email) values ('".$token."','".$email."')";
        mysql_query($q);

        function mailresetlink($to,$token,$name,$from,$bcc,$app)
        {
            $subject = "Forgot Password for ".$app."";
            $uri = 'http://'. $_SERVER['HTTP_HOST'] ;
            $message = '
            <html>
            <head>
            <title>Forgot Password for '.$app.'</title>
            </head>
            <body>
            <p>Hi,<br><br>You have requested the password reset link for your '.$app.' account!<br><br>
            You can change the password for your account here:<br><br>
            <a href="'.getcurrentpath().'resetpassword.php?token='.$token.'">Reset Password Link</a><br><br>
            If you need further assistance please contact support@prv.nl</p>
            </body>
            </html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= "From: ".$name."<".$from.">" . "\r\n";
            $headers .= "Bcc: ".$bcc."" . "\r\n";
            
            if(mail($to,$subject,$message,$headers)){
                echo "We have sent the password reset link to your email address: <b>".$to."</b>";
            }
        }
        if(isset($_GET['email']))mailresetlink($email,$token,$emailFromName,$emailFrom,$emailBCC,$appName);
    }
}
echo '</body></html>';
?>