simperium-reset-password
========================

This PHP script allows Simperium users to reset their password using a simple webpage to request an reset password link by email. By using the link in the e-mail the Simperium user can reset their password without knowing their original password. Because of the usage of a token, you can be sure that only the owner of the email address can use the correct password recovery link.

This script uses PHP, SMTP, MySQL, cURL and JSON. Make sure your web hosting is supporting these features, otherwise this script might not work..

To setup the Simperium Reset Password script follow these guidelines:

* Download the sources
* Create a database on your MySQL instance
* Create a user for your database on your MySQL instance
* Create the tokens table in your database, using the 'tokes_table.sql' script
* Change the 'settings.php' file according to your settings
* Upload the 'assets' folder to your web hosting
* Upload the PHP files to your web hosting
* Test your Simperium Reset Password script by opening 'forgotpassword.php' in your webbrowser! 

Things still to do:

* Add an option to execute the script directly from your App, so the user gets the email without leaving the App.
* Add an option to change the users current password
* Add an option to change the users current username

If you have feedback, feel free to contact me on support@prv.nl or add an issue!
