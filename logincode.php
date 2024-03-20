<?php
session_start();

// include file for database connection
include('config/db_conn.php');

// Check if user is not logged in via Facebook, redirect to login page
if (!isset($_SESSION['FacebookLoggedIn'])) {
    $_SESSION['status'] = "Access Denied.!";
    header("Location: Loginform.php");
    exit();
}

// check if both email and password are set in the POST
if (isset($_POST['login_btn'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // sanitize both email and password from POST request
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // check if email or password is empty
    if (empty($email) || empty($password)) {
        $_SESSION['status'] = "Email and password are required";
        header("Location: Loginform.php?error=Email and password are required");
        exit();
    } else {
        // Query to fetch user data with the given email
        $sql = "SELECT * FROM user_profile WHERE email=? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['status'] = "SQL Error";
            header("Location: Loginform.php?error=SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Verify password
                if (password_verify($password, $row['password'])) {
                    // Update Active status to "Active"
                    $update_sql = "UPDATE user_profile SET Active='Active' WHERE email=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $update_sql)) {
                        $_SESSION['status'] = "SQL Error";
                        header("Location: Loginform.php?error=SQL Error");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);

                        // Store user data in session variable
                        $_SESSION['auth'] = true;
                        $_SESSION['auth_user'] = [
                            'user_id' => $row['user_id'],
                            'full_name' => $row['full_name'],
                            'email' => $row['email'],
                            'phone_number' => $row['phone_number'],
                            'address' => $row['address']
                        ];

                        $_SESSION['status'] = "Logged in Successfully";
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $_SESSION['status'] = "Invalid email or password";
                    header("Location: Loginform.php?error=Invalid email or password");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Invalid email or password";
                header("Location: Loginform.php?error=Invalid email or password");
                exit();
            }
        }
    }
} else {
    // Check if the Facebook login session variable is set
    if (isset($_SESSION['FacebookLoggedIn'])) {
        // Retrieve user information from Facebook login
        $userProfile = $_SESSION['auth_user'];

        // Extract user details
        $user_id = $userProfile['user_id'];
        $full_name = $userProfile['full_name'];
        $email = $userProfile['email'];
        $phone_number = $userProfile['phone_number'];
        $address = $userProfile['address'];

        // Insert user details into the database
        $sql = "INSERT INTO user_profile (user_id, full_name, email, phone_number, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['status'] = "SQL Error";
            header("Location: Loginform.php?error=SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $full_name, $email, $phone_number, $address);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['status'] = "User details inserted successfully";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['status'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
                header("Location: Loginform.php");
                exit();
            }
        }
    } else {
        $_SESSION['status'] = "Access Denied.!";
        header("Location: Loginform.php");
        exit();
    }
}
?>
