<?php
session_start();

if(!isset($_SESSION['auth']))
{
    $_SESSION['auth_status'] = "Login to Access Dashboard";
    header("Location: Loginform.php");
}

// Check if the user is authenticated via Facebook login
if (!isset($_SESSION['FacebookLoggedIn'])) {
    $_SESSION['auth_status'] = "Login to Access Dashboard";
    header("Location: Loginform.php");
    exit;
}
?>