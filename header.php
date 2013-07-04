<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo "$pageTitle - $appName";?></title>
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
                    <a class="brand" href="index.php"><?php echo $appName;?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li <?php echo ($pageTitle == 'Forgot password') ? 'class="active"' : '';?>><a href="forgotpassword.php">Forgot password</a></li>
                            <li <?php echo ($pageTitle == 'Change password') ? 'class="active"' : '';?>><a href="changepassword.php">Change password</a></li>
                            <li <?php echo ($pageTitle == 'Change username') ? 'class="active"' : '';?>><a href="changeusername.php">Change username</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
    
