<?php
session_start();

// include file for database connection
include('config/db_conn.php');
// include file for
include('Authentication.php');

if(isset($_POST['logout_btn'])) {
    //session_destroy();
    unset($_SESSION['auth']); unset($_SESSION['auth_user']);
    $_SESSION['status'] = "Logged out successfully";
    header('Location: Loginform.php');
    exit(0);
}

// Check if the request method is POST
if(isset($_POST['AddUser'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Sanitize input data obtained from the POST request
    $full_name = validate($_POST['full_name']);
    $email = validate($_POST['email']);
    $phone_number = validate($_POST['phone_number']);
    $address = validate($_POST['address']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['confirm_password']);

        if($password == $confirm_password){

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format";
                header("Location: registered.php");
                exit();
            }

            // Check if email already exists in the database
            $email_check_query = "SELECT * FROM user_profile WHERE email='$email' LIMIT 1";
            $result = mysqli_query($conn, $email_check_query);
            $user = mysqli_fetch_assoc($result);

            // If email already exists
            if ($user) {
                $_SESSION['error'] = "Email already exists";
                header("Location: registered.php");
                exit();
            }


            // SQL query to insert user data into the database
            $sql = "INSERT INTO user_profile (full_name,email,phone_number,address,password)
                    VALUES ('$full_name','$email','$phone_number','$address','$password')";
                
            if (mysqli_query($conn, $sql)) {
                // Redirect with a success message
                $_SESSION['status'] = "User Added Successfully";
                header("Location: registered.php");
            } else {
                // Display an error message if the query fails
                $_SESSION['status'] = "User Registration Failed";
                header("Location: registered.php");
            }
        }
        else
        {
            // Display an error message if the query fails
            $_SESSION['status'] = "Password and Confirm Password does not match.!";
            header("Location: registered.php");
        }

    }

// Check if the request method is POST
if(isset($_POST['UpdateUser'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Ensure fields is initialized
    $user_id = $_POST['user_id'];
    $full_name = ($_POST['full_name']);
    $email = ($_POST['email']);
    $phone_number = ($_POST['phone_number']);
    $address = ($_POST['address']);
    $password = ($_POST['password']);

    // Construct SQL query for updating user profile
    $sql = "UPDATE user_profile SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address', password = '$password' WHERE user_id = '$user_id' ";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect with a success message
        $_SESSION['status'] = "User Update Successfully";
        header("Location: registered.php");
    } else {
        // Display an error message if the query fails
        $_SESSION['status'] = "User Updating Failed";
        header("Location: registered.php");
    }
}

// Check if the request method is POST
if(isset($_POST['DeleteUserbtn'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_id = $_POST['delete_id'];

    $sql = "DELETE FROM user_profile WHERE user_id = '$user_id' ";
    if (mysqli_query($conn, $sql)) {
        // Redirect with a success message
        $_SESSION['status'] = "User Deleted Successfully";
        header("Location: registered.php");
    } else {
        // Display an error message if the query fails
        $_SESSION['status'] = "User Deleting Failed";
        header("Location: registered.php");
    }

}
?>