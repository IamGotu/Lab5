<?php
session_start();

// include file for database connection
include ('config/db_conn.php');

// check if the both username are set in the POST
if (isset($_POST['login_btn'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // sanitize both username and password from POST request
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

        $sql = "SELECT * FROM user_profile WHERE email='$email' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                foreach($result as $row){
                    $user_id = $row['user_id'];
                    $full_name = $row['full_name'];
                    $email = $row['email'];
                    $phone_number = $row['phone_number'];
                    $address = $row['address'];
                }

                $_SESSION['auth'] = true;
                $_SESSION['auth_user'] = [
                    'user_id' => $user_id,
                    'full_name' => $full_name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'address' => $address
                ];

                $_SESSION['status'] = "Logged in Successfully";
                var_dump($_SESSION['status']); // Debugging statement
                header("Location: index.php");
                exit(); // Ensure no further code execution after redirection
    }
    else
    {
        $_SESSION['status'] = "Invalid email or password";
        var_dump($_SESSION['status']); // Debugging statement
        header("Location: Loginform.php");
        exit(); // Ensure no further code execution after redirection
    }
}
else
{
    $_SESSION['status'] = "Access Denied.!";
    var_dump($_SESSION['status']); // Debugging statement
    header("Location: Loginform.php");
    exit(); // Ensure no further code execution after redirection
}
?>