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

echo '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Forgot Password - '.$appName.'</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <style type="text/css">
            body {
                padding-top: 100px;
                padding-bottom: 40px;
                background-color: #f5f5f5 !important;
            }

            .placeholder {
                color: #aaa !important;
            }

            .form-signin {
                max-width: 350px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

    </head>

    <body>
        
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#">'.$appName.'</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="forgotpassword.php">Forgot Password</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
            <form class="form-signin" method="post">';
    
if($action=="Success")
{
                echo '<h2>Verification email</h2>
                <p>We have sent the password reset link for '.$appName.' to your email address: <b>'.$email.'</b><br/>
                Please read the email for further instructions!
                </p>';
}
else
{
                echo '<h2>Forgot your password</h2>
                <p>Please enter the email address you signed up with to receive a password reset link for '.$appName.'</p>
                <input type="text" class="input-block-level" name="email" placeholder="Email address">';

    if($alert)
    {
                echo '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                '.$alert.'
                </div>';
    }
    
                echo '<button class="btn btn-large btn-inverse" type="submit">Reset my password</button>';
}
            echo '</form>
        </div> <!-- /container -->
            
        <!-- JavaScripts placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

        <!-- Invoke the input placeholder plugin for < IE 10 -->
        <!--[if lt IE 10]>
            <script src="assets/js/jquery.placeholder.js?v=2.0.7"></script>
            <script>

            $(function() {
              $("input, textarea").placeholder();
              });
            </script>
        <![endif]-->

    </body>
</html>';
?>
