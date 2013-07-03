<?php
//file resetpassword.php

include("settings.php");
include("functions.php");

connect();

session_start();

$token=$_GET['token'];
$pass=$_POST['password'];
$email=$_SESSION['email'];
$action="Check";

if (isset($_POST['action'])) {
  $action=$_POST['action'];
}

if($action=="Save")
{
    if($pass!='')
    {
        $q="update tokens set used=1 where token='".$token."' and email='".$email."' and used=0";
        $r=mysql_query($q);
        
        if(mysql_affected_rows()==1)
        {
            $ch = curl_init("https://auth.simperium.com/1/".$app_id."/reset_password/");

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" .$email."&new_password=".$pass."");
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('X-Simperium-API-Key:'.$adminKey.''));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($ch);
            
            $jsonArray = json_decode($result);
            
            if($jsonArray->{'status'} === "success")
            {
                $action = "Success";
            }
            else
            {
                $alert = "An error occured, please try again..";
                $action = "Check";
            }
        }
        else
        {
            $action = "Error";
        }
    }
    else
    {
        $alert = "Please enter your new password..";
        $action = "Check";
    }
    
}

if($action=="Check")
{
    //Check if token exists in the database
    $q="select email from tokens where token='".$token."' and used=0";
    $r=mysql_query($q);
    if($row=mysql_fetch_array($r))
    {
        //The token exists, add email to session object
        $_SESSION['email']=$row['email'];
        $email=$_SESSION['email'];
    }
    else
    {
        //Token not found, display error
        $action = "Error";
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
        </div>';

        echo '<div class="container">
            <form class="form-signin" method="post">';

if($action=="Check")
{
                echo '<h2>Forgot your password</h2>
                <p>Please enter your new password for: <b>'.$email.'</b></p>
                <input type="password" class="input-block-level" name="password" placeholder="New password">
                <input type="hidden" name="action" value="Save">';
                
                if($alert)
                {
                    echo '<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    '.$alert.'
                    </div>';
                }
                echo '<button class="btn btn-large btn-inverse" type="submit">Change Password</button>';
}
elseif($action=="Success")
{
                echo '<h2>Password changed!</h2>
                <p>The password for your account is succesfully changed!<br/>
                If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a>
                </p>';
}
else
{
                echo '<h2>Error occurred</h2>
                <p>This password reset link is invalid or the password is already changed..<br/>
                If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a>
                </p>';
}

            echo '</form>
        </div> <!-- /container -->';
    
        echo '<!-- JavaScripts placed at the end of the document so the pages load faster -->
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
