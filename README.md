simperium-user-manager
========================

This PHP website allows users to manage their user account for a specific App that is using the Simperium platform. The website is using a Bootstrap Responsive HTML5 layout and gives the user the following options:

<b>Forgot password:</b>
When the user looses the password, the user can request a password reset link by email. By using the link in the email the user can reset their password without knowing their original password. Because of the usage of a token, you can be sure that only the owner of the email address can use the correct password recovery link.

<b>Change password:</b>
With this option the user can change their password. The user needs the current account details to change the password.

<b>Change username:</b>
With this option the user can change their username. The user needs the current account details to change the username.

This script uses PHP, SMTP, MySQL, cURL and JSON. Make sure your web hosting is supporting these features, otherwise this script might not work..

To setup the Simperium User Manager script follow these guidelines:

* Download the sources
* Create a database on your MySQL instance
* Create a user for your database on your MySQL instance
* Create the tokens table in your database, using the 'tokes_table.sql' script
* Change the 'settings.php' file according to your settings (the Simperium API Key and Admin Key can be found in the Simperium Dashboard)
* Upload the 'usermanager' folder to your web hosting
* Test your Simperium Reset Password script by opening the 'usermanager' location in your web browser! 

A live version of the Simperium User Manager is available at: http://prv.nl/tools/usermanager/

Things still to be done:

* Update MySQL to functions to MySQLi functions
* Use parameterized MySQLi query for aditional security

If you have feedback, feel free to contact me on support@prv.nl or add an issue!
