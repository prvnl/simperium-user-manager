<?php
//file resetpassword.php

include("settings.php");
include("functions.php");

session_start();

$token=$_GET['token'];
$password=$_POST['password'];
$email=$_SESSION['email'];
$action="Check";

if (isset($_POST['action'])) {
  $action=$_POST['action'];
}

if($action=="Save")
{
    if($password!='')
    {
        //Update token to used and change Simperium password
        $mysqli = dbConnect();
        
        $stmt = $mysqli->prepare("UPDATE tokens SET used = 1 WHERE token = ? AND email = ? AND used = 0");

        $stmt->bind_param('ss', $token, $email);
        
        if(!$stmt->execute())
        {
            echo 'Could not execute query: '.$stmt->error;
            $action = "Error";
        }
        else
        {
            if($stmt->affected_rows==1)
            {
                $ch = curl_init("https://auth.simperium.com/1/".$app_id."/reset_password/");
                
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" .$email."&new_password=".$password);
                curl_setopt($ch, CURLOPT_HTTPHEADER,array('X-Simperium-API-Key:'.$adminKey));
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
        
        $stmt->close();
        $mysqli->close();

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
    $mysqli = dbConnect();
    
    $stmt = $mysqli->prepare("SELECT email FROM tokens WHERE token = ? AND used = 0");

    $stmt->bind_param('s', $token);
    
    if(!$stmt->execute())
    {
        echo 'Could not execute query: '.$stmt->error;
    }
    else
    {
        $stmt->store_result();
    
        $stmt->bind_result($email_result);
        
        $numrows = $stmt->num_rows;
        
        if($numrows==1)
        {
            //The token exists, add email to session object
            while($stmt->fetch()) 
            { 
                $_SESSION['email']=$email_result;
                $email=$_SESSION['email'];
            }
        }
        else
        {
            //Token not found, display error
            $action = "Error";
        }
    }
    
    $stmt->close();
    $mysqli->close();

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
