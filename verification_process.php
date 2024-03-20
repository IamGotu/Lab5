<?php
session_start();

// Include file for database connection
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the verification code and email from the form
    $verification_code = $_POST['verification_code'];
    $email = $_POST['email'];

    // SQL query to check if the verification code matches the one stored in the database
    $sql = "SELECT * FROM user WHERE Email='$email' AND verify_token='$verification_code' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Update the user's record to mark them as verified
        $update_sql = "UPDATE user SET Status='Verified' WHERE Email='$email' AND verify_token='$verification_code'";
        if (mysqli_query($conn, $update_sql)) {
            // Redirect the user to a page indicating successful verification
            header("Location: verification_success.php");
            exit();
        } else {
            // Display an error message if the update fails
            header("Location: verification_error.php?message=Error updating record");
            exit();
        }
    } else {
        // Redirect the user to a page indicating invalid verification code
        header("Location: verification_error.php?message=Invalid verification code");
        exit();
    }
} else {
    // Redirect the user if they try to access this page directly
    header("Location: verification_error.php?message=Invalid request");
    exit();
}

mysqli_close($conn);
?>
