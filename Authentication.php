<?php
session_start();

if(!isset($_SESSION['auth_user']))
{
    $_SESSION['status'] = "Login to Access Dashboard";
    header("Location: Loginform.php");
}
?>