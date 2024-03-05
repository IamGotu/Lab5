<?php
include('Authentication.php');
include('config/db_conn.php');

if(isset($_POST['signup_btn'])) {
    $full_name = $_POST['full_name'];   
    $email = $_POST['email'];   
    $phone_number = $_POST['phone_number'];   
    $address = $_POST['address'];   
    $password = $_POST['password'];   
    $profile_picture = $_FILES['profile_picture']['name']; // Original file name
    
    $allowed_extension = array('png', 'jpg', 'jpeg');
    $file_extension = pathinfo($profile_picture, PATHINFO_EXTENSION);
    
    if(!in_array($file_extension, $allowed_extension)) {
        $_SESSION['status'] = "You are allowed with only jpg, png, jpeg image";
        header('Location: signupform.php');
        exit(0);
    }
    // Check if the email already exists in the database
    $check_email_query = "SELECT * FROM user_profile WHERE email='$email' LIMIT 1 ";
    $check_email_query_run = mysqli_query($conn, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email already exists";
        header('Location: signupform.php');
        exit();
    } else {
        // Insert user data into the database
        $insert_query = "INSERT INTO user_profile (full_name, email, phone_number, address, password, profile_picture) VALUES ('$full_name', '$email', '$phone_number', '$address', '$password', '$profile_picture')";
        $insert_query_run = mysqli_query($conn, $insert_query);

        if($insert_query_run) {
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/'.$profile_picture); // Move uploaded file with original name
            $_SESSION['status'] = "Account created successfully. Please login.";
            header('Location: Loginform.php');
            exit();
        } else {
            $_SESSION['status'] = "Failed to create account. Please try again.";
            header('Location: signupform.php');
            exit(0);
        }
    }
} else {
    $_SESSION['status'] = "Access Denied";
    header('Location: signupform.php');
    exit();
}
?>