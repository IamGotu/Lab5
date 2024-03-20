<?php 
// Include file for database connection
include('config/db_conn.php');
// Include file for authentication
include('Authentication.php');

// Check if the request method is POST
if(isset($_POST['UpdateUser'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Ensure fields are initialized
    $user_id = $_POST['user_id'];
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
        header('Location: User_Profile.php');
        exit(0);
    }

    // Construct SQL query for updating user profile
    $sql = "UPDATE user_profile SET full_name = ?, email = ?, phone_number = ?, address = ?, password = ?, profile_picture = ? WHERE user_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssi", $full_name, $email, $phone_number, $address, $password, $profile_picture, $user_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/'.$profile_picture); // Move uploaded file with original name
        $_SESSION['status'] = "User Update Successfully"; // Set success message
        header('Location: User_Profile.php');
        exit(0);
    } else {
        $_SESSION['status'] = "Profile Picture Updating Failed";
        header('Location: User_Profile.php');
        exit(0);
    }
} else {
    // Display an error message if the form was not submitted
    $_SESSION['status'] = "User Updating Failed";
    header("Location: User_Profile.php");
    exit(0);
}
?>

