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

//Set parameters for header include
$pageTitle="Forgot password";
//Header include
include("header.php");

        echo '<div class="container">
            <form class="form-signin" method="post">';

if($action=="Check")
{
                echo '<h2>Forgot password</h2>
                <p>Please enter your new password for: <b>'.$email.'</b></p>
                <input type="password" class="input-block-level" name="password" placeholder="New password" required>
                <input type="hidden" name="action" value="Save">';
                
                if($alert)
                {
                    echo '<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    '.$alert.'
                    </div>';
                }
                echo '<button class="btn btn-large btn-inverse" type="submit">Change password</button>';
}
elseif($action=="Success")
{
                echo '<h2>Password changed!</h2>
                <p>The password for your account is succesfully changed!<br/><br/>
                If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a>
                </p>';
}
else
{
                echo '<h2>Error occurred</h2>
                <p>This password reset link is invalid or the password is already changed..<br/><br/>
                If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a>
                </p>';
}

            echo '</form>
        </div> <!-- /container -->';
    
//Footer include
include("footer.php");

?>
