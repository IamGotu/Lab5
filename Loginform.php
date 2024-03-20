<?php
session_start();
include('includes/header.php');
if(isset($_SESSION['auth']))
{
    $_SESSION['status'] = "You are already logged In";
    header('Location: index.php');
    exit(0);
}

?>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-5 my-5">
                <div class="card my-5">
                    <div class="card-header bg-light">
                        <h5>Login</h5>
                    </div>
                    <div class="card-body">
                        <?php
                            if(isset($_SESSION['auth_status']))
                            {
                                ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Hey!</strong> <?php echo $_SESSION['auth_status']; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php
                                unset($_SESSION['auth_status']);
                            }
                        ?>
                        <?php
                            include('message.php');
                        ?>
                        
                        <!-- Existing Login Form -->
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

                            <div class="modal-footer">
                                <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
                            </div>
                            
                            <div class="modal-footer">
                            <?php
                                require_once 'vendor/autoload.php';

                                // init configuration
                                $clientID = '193313335542-3ontmojidvvgv28ocd644api5jr7rg31.apps.googleusercontent.com'; // your client id
                                $clientSecret = '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'; // your client secret
                                $redirectUri = 'http://localhost/Lab5/Loginform.php';

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
                                ?>

                                <?php } else {?>
                                    <hr>
                                    <center><a href="<?php echo $client->createAuthUrl() ?>"><img src="https://imgs.search.brave.com/1gvCbOm37ntWXBfEVew0Ayy8kgmUKfKkIYdkaOURx1o/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9kZXZl/bG9wZXJzLmdvb2ds/ZS5jb20vc3RhdGlj/L2lkZW50aXR5L2lt/YWdlcy9icmFuZGlu/Z19ndWlkZWxpbmVf/c2FtcGxlX250X3Nx/X2xnLnN2Zw.svg" width="169.14"></a></center>
                                <?php }
                            ?>

                            <hr>

                            <?php
                                require_once 'vendor/autoload.php';

                                $fb = new Facebook\Facebook([
                                'app_id' => '1789119144849191', // your app id
                                'app_secret' => '4864ce4912091602c2aaa0dcfa9520b7', // your app secret
                                'default_graph_version' => 'v2.4',
                                ]);

                                $helper = $fb->getRedirectLoginHelper();
                                $permissions = ['email']; // optional
                                try {
                                if (isset($_SESSION['facebook_access_token'])) {
                                $accessToken = $_SESSION['facebook_access_token'];
                                } else {
                                $accessToken = $helper->getAccessToken();
                                }
                                } catch(Facebook\Exceptions\facebookResponseException $e) {
                                // When Graph returns an error
                                echo 'Graph returned an error: ' . $e->getMessage();
                                exit;
                                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                                // When validation fails or other local issues
                                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                exit;
                                }
                                if (isset($accessToken)) {
                                if (isset($_SESSION['facebook_access_token'])) {
                                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                                } else {
                                // getting short-lived access token
                                $_SESSION['facebook_access_token'] = (string) $accessToken;
                                // OAuth 2.0 client handler
                                $oAuth2Client = $fb->getOAuth2Client();
                                // Exchanges a short-lived access token for a long-lived one
                                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                                // setting default access token to be used in script
                                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                                }
                                // redirect the user to the profile page if it has "code" GET variable
                                if (isset($_GET['code'])) {
                                header('Location: index.php');
                                }
                                // getting basic info about user
                                try {
                                $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
                                $profile = $profile_request->getGraphUser();
                                $fbid = $profile->getProperty('id');           // To Get Facebook ID
                                $fbfullname = $profile->getProperty('name');   // To Get Facebook full name
                                $fbemail = $profile->getProperty('email');    //  To Get Facebook email
                                $fbpic = "<img src='https://graph.facebook.com/$fbid/picture?redirect=true'>";
                                # save the user information in session variable
                                $_SESSION['fb_id'] = $fbid.'</br>';
                                $_SESSION['fb_name'] = $fbfullname.'</br>';
                                $_SESSION['fb_email'] = $fbemail.'</br>';
                                $_SESSION['fb_pic'] = $fbpic.'</br>';
                                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                                // When Graph returns an error
                                echo 'Graph returned an error: ' . $e->getMessage();
                                session_destroy();
                                // redirecting user back to app login page
                                header("Location: ./");
                                exit;
                                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                                // When validation fails or other local issues
                                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                exit;
                                }
                                } else {
                                    ?>
                                    <?php
                                    $loginUrl = $helper->getLoginUrl('https://rename-online.com/facebook-login-using-php/', $permissions);
                                    ?>
                                    <center><a href="<?php echo $loginUrl; ?>" class="btn btn-primary btn-block"><i class="fab fa-facebook-square"></i> Log in with Facebook!</a></center>
                                <?php } ?>
                            </div>
                            
                        </form>

                        <div class="text-center">
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
