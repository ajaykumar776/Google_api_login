


<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('619289382967-onm730mo4t37hc3qsi658ndm11l2tno3.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('AMS9ZMuQs3nd3heuNispzHR9');


//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/ajay/Google_api_login/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>