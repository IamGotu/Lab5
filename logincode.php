<?php
session_start();

// include file for database connection
include ('config/db_conn.php');

// Check if user is not logged in, redirect to login page
if (isset($_SESSION['success_message'])) {
    header("Location: Dashboard.php");
    exit();
}

// check if both email and password are set in the POST
if (isset($_POST['login_btn'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // sanitize both email and password from POST request
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // check if email or password is empty
    if (empty($email)) {
        $_SESSION['status'] = "Email is required";
        header("Location: Loginform.php?error=Email is required");
        exit();
    } else if (empty($password)) {
        $_SESSION['status'] = "Password is required";
        header("Location: Loginform.php?error=Password is required");
        exit();    
    } else {
        // Query to fetch user data with the given email and password
        $sql = "SELECT * FROM user_profile WHERE email='$email' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data
            $row = mysqli_fetch_assoc($result);

            // Update Active status to "Active"
            $update_sql = "UPDATE user_profile SET Active='Online' WHERE email='$email'";
            mysqli_query($conn, $update_sql);

            // storing in session variable
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $row['user_id'],
                'full_name' => $row['full_name'],
                'birthdate' => $row['birthdate'],
                'email' => $row['email'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address']
            ];

            $_SESSION['status'] = "Logged in Successfully";
            header("Location: Dashboard.php");
            exit();
        } else {
            $_SESSION['status'] = "Invalid email or password";
            header("Location: Loginform.php?error=Invalid email or password");
            exit();
        }
    }
} else {
    $_SESSION['status'] = "Access Denied.!";
    header("Location: Loginform.php?error=Access Denied");
    exit();
}
?>