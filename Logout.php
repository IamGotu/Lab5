<?php
session_start();

// Include file for database connection
include('config/db_conn.php');

if (isset($_POST['logout_btn'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_SESSION['auth'])) {
        // Fetch email from session
        $full_name = $_SESSION['auth_user']['full_name'];

        // Update Active status to "Offline" for the logged-out user
        $update_sql = "UPDATE user_profile SET Active='Offline' WHERE full_name='$full_name'";
        mysqli_query($conn, $update_sql);
    }

    // Unset all of the session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: Loginform.php");
    exit();
}
?>
