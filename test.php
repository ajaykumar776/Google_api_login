<?php

//index.php

//Include Configuration File
include('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


    if(!isset($token['error']))
    {
    
        $google_client->setAccessToken($token['access_token']);

        
        $_SESSION['access_token'] = $token['access_token'];


        $google_service = new Google_Service_Oauth2($google_client);

        
        $data = $google_service->userinfo->get();

    
        if(!empty($data['given_name']))
        {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name']))
        {
        $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email']))
        {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($data['gender']))
        {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if(!empty($data['picture']))
        {
        $_SESSION['user_image'] = $data['picture'];
        }
    }
}


if(!isset($_SESSION['access_token']))
{

 $login_button = '<a href="'.$google_client->createAuthUrl().'"><html>
 <head>
   <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
   <script src="https://apis.google.com/js/api:client.js"></script>
   <script>
   var googleUser = {};
   var startApp = function() {
     gapi.load('auth2', function(){
       // Retrieve the singleton for the GoogleAuth library and set up the client.
       auth2 = gapi.auth2.init({
         client_id: 'YOUR_CLIENT_ID.apps.googleusercontent.com',
         cookiepolicy: 'single_host_origin',
         // Request scopes in addition to 'profile' and 'email'
         //scope: 'additional_scope'
       });
       attachSignin(document.getElementById('customBtn'));
     });
   };
 
   function attachSignin(element) {
     console.log(element.id);
     auth2.attachClickHandler(element, {},
         function(googleUser) {
           document.getElementById('name').innerText = "Signed in: " +
               googleUser.getBasicProfile().getName();
         }, function(error) {
           alert(JSON.stringify(error, undefined, 2));
         });
   }
   </script>
   <style type="text/css">
     #customBtn {
       display: inline-block;
       background: white;
       color: #444;
       width: 190px;
       border-radius: 5px;
       border: thin solid #888;
       box-shadow: 1px 1px 1px grey;
       white-space: nowrap;
     }
     #customBtn:hover {
       cursor: pointer;
     }
     span.label {
       font-family: serif;
       font-weight: normal;
     }
     span.icon {
       background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;
       display: inline-block;
       vertical-align: middle;
       width: 42px;
       height: 42px;
     }
     span.buttonText {
       display: inline-block;
       vertical-align: middle;
       padding-left: 42px;
       padding-right: 42px;
       font-size: 14px;
       font-weight: bold;
       /* Use the Roboto font that is loaded in the <head> */
       font-family: 'Roboto', sans-serif;
     }
   </style>
   </head>
   <body>
   <!-- In the callback, you would hide the gSignInWrapper element on a
   successful sign in -->
   <div id="gSignInWrapper">
     <span class="label">Sign in with:</span>
     <div id="customBtn" class="customGPlusSignIn">
       <span class="icon"></span>
       <span class="buttonText">Google</span>
     </div>
   </div>
   <div id="name"></div>
   <script>startApp();</script>
 </body>
 </html></a>';
}

?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> Login using Google Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 
</head>
<body>
    <div class="container">
        <div class="card-header">
            <br/>
            <h2 align="center"> Login using Google Account</h2>
            <br/>
        </div>
        <br><br>
        <div class="box" style="border-radius:50px solid red;">
            <div class="panel panel-default">
                    <?php
                        if($login_button == '')
                        {
                            echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                            echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                            echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                            echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                            echo '<h3><a href="logout.php">Logout</h3></div>';
                        }
                        else
                            {
                                echo '<div align="center">'.$login_button . '</div>';
                            }
                    ?>   
            </div>
        </div>
    </div>
 </body>
</html>