<?php

require_once ("../Google_login/vendor/autoload.php");

session_start();

// init configuration
$clientID = '147613768576-2bund5num0s4eams0tglrgav3vauu79j.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/LAB5/sample/welcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ipt101";

$conn = mysqli_connect($hostname, $username, $password, $database);
?>