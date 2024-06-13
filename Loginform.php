<?php
session_start();
include('includes/header.php');

if (isset($_SESSION['auth'])) {
    $_SESSION['status'] = "You are already logged in";
    header('Location: Dashboard.php');
    exit(0);
}

include("config/db_conn.php");
require_once('Google_login/vendor/autoload.php');

// Google OAuth configuration
$clientID = '147613768576-2bund5num0s4eams0tglrgav3vauu79j.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:3000/Loginform.php'; // Make sure this URI matches your OAuth 2.0 credentials setup

// Create Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Handle Google OAuth callback
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // Get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $full_name = $google_account_info->name;

        // Insert or update user profile data in the database
        $sql = "INSERT INTO user_profile (email, full_name) VALUES (?, ?) ON DUPLICATE KEY UPDATE full_name=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $full_name, $full_name);

        if ($stmt->execute()) {
            // Fetch the user_id from the database
            $sql = "SELECT user_id FROM user_profile WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $user['user_id'],
                'email' => $email,
                'full_name' => $full_name
            ];
            header('Location: Dashboard.php');
            exit(0);
        } else {
            $_SESSION['status'] = "Database error: " . $stmt->error;
            header('Location: Loginform.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Google OAuth error: " . $token['error'];
        header('Location: Loginform.php');
        exit(0);
    }
}
?>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 my-5">
                <div class="card my-5">
                    <div class="card-header bg-light">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <?php include('message.php'); ?>
                        <form action="logincode.php" method="POST">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <hr>
                            <div class="form-group">
                                <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <hr>
                        </form>
                        <div class="form-group">
                            <?php
                            // Display Google Login URL
                            echo "<a href='" . $client->createAuthUrl() . "' class='btn btn-danger btn-block'>Login with Google</a>";
                            ?>
                        </div>
                        <br>
                        <p>Don't have an account? <a href="signupform.php" class="btn-sm">Sign Up</a></p>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>
