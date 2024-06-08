<?php
session_start();
include('includes/header.php');
if(isset($_SESSION['auth']))
{
    $_SESSION['status'] = "You are already logged In";
    header('Location: Dashboard.php');
    exit(0);
}
include ("config/db_conn.php");
require_once ('Google_login/vendor/autoload.php');
?>

    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-md-5 my-5">
                    <div class="card my-5">
                        <div class="card-header bg-light">
                            <h5>Login Form</5>
                        </div>
                        <div class="card-body">

                            <?php
                                include('message.php');
                            ?>

                            <form action="logincode.php" method="POST">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <span></span>
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

                                <?php
                                // init configuration
                                $clientID = '147613768576-2bund5num0s4eams0tglrgav3vauu79j.apps.googleusercontent.com';
                                $clientSecret = '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';
                                $redirectUri = 'http://localhost:3000/Dashboard.php';

                                // create Client Request to access Google API
                                $client = new Google_Client();
                                $client->setClientId($clientID);
                                $client->setClientSecret($clientSecret);
                                $client->setRedirectUri($redirectUri);
                                $client->addScope("email");
                                $client->addScope("profile");

                                // authenticate code from Google OAuth Flow
                                if (isset($_GET['code'])) {
                                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                                $client->setAccessToken($token['access_token']);

                                // get profile info
                                $google_oauth = new Google_Service_Oauth2($client);
                                $google_account_info = $google_oauth->userinfo->get();
                                $email =  $google_account_info->email;
                                $name =  $google_account_info->name;

                                // Insert or update user profile data in the database
                                $sql = "INSERT INTO user_profile (email, full_name) VALUES (?, ?) ON DUPLICATE KEY UPDATE full_name=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sss", $email, $name, $name);

                                if ($stmt->execute()) {
                                    echo "User profile data saved successfully.";
                                } else {
                                    echo "Error: " . $stmt->error;
                                }

                                $stmt->close();
                                $conn->close();

                                // Redirect to dashboard or any other page
                                header('Location: dashboard.php');

                                // now you can use this profile info to create account in your website and make user logged in.
                                } else {
                                echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
                                }
                                ?>

                                <br>

                                <p>Don't have an account? <a href="signupform.php" class="btn-sm">Sign Up</a></p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>