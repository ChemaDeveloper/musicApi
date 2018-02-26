<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>App de música</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/users.js"></script>
    <script type="text/javascript" src="js/navigation.js"></script>
    <script type="text/javascript" src="js/defaults.js"></script>
    <script type="text/javascript">checkAlowedNavigation();</script>
  </head>
  <body onload="getUserData()">
  	

    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="form-login">
                <h4>Update</h4>
                <input type="text" id="nameUpdate" class="form-control input-sm chat-input" placeholder="username" />
                </br>
                <input type="text" id="passwordUpdate" class="form-control input-sm chat-input" placeholder="password" />
                </br>
                <div class="wrapper">
                <span class="group-btn">     
                    <a href="javascript:updateUser()" class="btn btn-primary btn-md">Update user</a>
                </span>
                </div>
                </div>
            
            </div>

        </div>
    </div>
  	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>