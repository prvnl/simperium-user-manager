<?php
//file name: forgotpassword.php

include("settings.php");
include("functions.php");

if(isset($_POST['email']))
{
    $email=$_POST['email'];
    
    //Connect to Simperium to check if the username exists
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
        $alert = "This user account does not exists..";
    }
    else
    {
        //User account exists
        $token=getRandomString(10);

        connect();
        $q="insert into tokens (token,email) values ('".$token."','".$email."')";
        mysql_query($q);
        
        //Set email parameters
        $subject = "Forgot Password for ".$appName."";
        $uri = 'http://'. $_SERVER['HTTP_HOST'] ;
        $message = '
        <html>
        <head>
        <title>Forgot Password for '.$appName.'</title>
            </head>
            <body>
            <p>Hi,<br><br>You have requested the password reset link for your '.$appName.' account!<br><br>
                You can change the password for your account here:<br><br>
                    <a href="'.getcurrentpath().'resetpassword.php?token='.$token.'">Reset Password Link</a><br><br>
                    If you need further assistance please contact '.$emailFrom.'</p>
                    </body>
                    </html>';
                    $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "From: ".$emailFromName."<".$emailFrom.">" . "\r\n";
        $headers .= "Bcc: ".$emailBCC."" . "\r\n";
        
        if(mail($email,$subject,$message,$headers)){
            $action="Success";
        }
    }
}

//Set parameters for header include
$pageTitle="Forgot password";
//Header include
include("header.php");

        echo '<div class="container">
            <form class="form-signin" method="post">';
    
if($action=="Success")
{
                echo '<h2>Verification email</h2>
                <p>We have sent the password reset link for '.$appName.' to your email address: <b>'.$email.'</b><br/><br/>
                Please read the email for further instructions!
                </p>';
}
else
{
                echo '<h2>Forgot password</h2>
                <p>Please enter the email address you signed up with to receive a password reset link for '.$appName.'</p>
                <input type="email" class="input-block-level" name="email" placeholder="Email address" required>';

    if($alert)
    {
                echo '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                '.$alert.'
                </div>';
    }
    
                echo '<button class="btn btn-large btn-inverse" type="submit">Reset password</button>';
}
            echo '</form>
        </div> <!-- /container -->';
    
//Footer include
include("footer.php");

?>
