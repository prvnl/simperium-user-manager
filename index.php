<?php
//file name: index.php

include("settings.php");

//Set parameters for header include
$pageTitle="User manager";
//Header include
include("header.php");

        echo'<div class="container">

                <form class="form-signin" method="post">

                    <h2>User manager</h2>
                    <p>Welcome to the user manager for '.$appName.', the user manager give you tools to manage your user account!<br/><br/>
                    If you need additional support, please contact: <a href="mailto:'.$emailFrom.'">'.$emailFrom.'</a></p>

                </form>
        </div>

        <div class="container">
    
            <div class="row">
                <div class="span4">
                    <h2>Forgot password</h2>
                    <p>Did you loose your password for '.$appName.', then use the option \'Forgot password\' to recover your password. For a password recovery you need access to the e-mail you used for registering.</p>
                    <p><a class="btn" href="forgotpassword.php">View details &raquo;</a></p>
                </div>
                <div class="span4">
                    <h2>Change password</h2>
                    <p>Do you want to change your password for '.$appName.', then use the option \'Change password\' to change your password. You need your current account details to change your password.</p>
                    <p><a class="btn" href="changepassword.php">View details &raquo;</a></p>
                </div>
                <div class="span4">
                    <h2>Change username</h2>
                    <p>Do you want to change your username for '.$appName.', then use the option \'Change username\' to change your username. You need your current account details to change your username.</p>
                    <p><a class="btn" href="changeusername.php">View details &raquo;</a></p>
                </div>
            </div>

        </div> <!-- /container -->';


//Footer include
include("footer.php");

?>
