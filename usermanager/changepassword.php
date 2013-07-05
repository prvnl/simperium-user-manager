<?php
//file name: chnagepassword.php

include("settings.php");
include("functions.php");

$user = $_POST['user'];
$password = $_POST['password'];
$new_password = $_POST['new_password'];
$new_password_confirm = $_POST['new_password_confirm'];

$action = "default";

if(isset($user)&&isset($password))
{
    if(newPasswordIsValid())
    {
        //Connect to Simperium to change password
        $ch = curl_init("https://auth.simperium.com/1/".$app_id."/update/");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$user."&password=".$password."&new_password=".$new_password."");
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('X-Simperium-API-Key:'.$apiKey.''));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($ch);
        
        $jsonArray = json_decode($result);
        
        if($jsonArray->{'status'} === "success")
        {
            $action = "Success";
        }
        else
        {
            $alert = "An error occured, please try again..<br/>Error: ".$result."";
        }
    }

}

//Set parameters for header include
$pageTitle="Change password";
//Header include
include("header.php");

        echo '<div class="container">
            <form class="form-signin" method="post">';
    
if($action=="Success")
{
                echo '<h2>Password changed!</h2>
                <p>The password for your account is succesfully changed!<br/><br/>
                If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a>
                </p>';
}
else
{
                echo '<h2>Change password</h2>
                <p>Please enter your username and current password for '.$appName.' and enter and confirm the new password you want to use!</p>
                <input type="email" class="input-block-level" name="user" placeholder="Username (email@email.com)" value="'.$user.'" required>
                <input type="password" class="input-block-level" name="password" placeholder="Current password" required>
                <input type="password" class="input-block-level" name="new_password" placeholder="New password" required>
                <input type="password" class="input-block-level" name="new_password_confirm" placeholder="Confirm new password" required>';

    if($alert)
    {
                echo '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                '.$alert.'
                </div>';
    }
    
                echo '<button class="btn btn-large btn-inverse" type="submit">Change password</button>';
}
            echo '</form>
        </div> <!-- /container -->';
            
//Footer include
include("footer.php");

?>
