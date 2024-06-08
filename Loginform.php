<?php
session_start();
include('includes/header.php');
if(isset($_SESSION['auth']))
{
    $_SESSION['status'] = "You are already logged In";
    header('Location: Dashboard.php');
    exit(0);
}

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

                                <!-- Sign In With Google button with HTML data attributes API -->
                                <script src="https://accounts.google.com/gsi/client" async></script>

                                <script>
                                    // Credential response handler function
                                    function handleCredentialResponse(response){
                                        // Post JWT token to server-side
                                        fetch("auth_init.php", {
                                            method: "POST",
                                            headers: { "Content-Type": "application/json" },
                                            body: JSON.stringify({ request_type:'user_auth', credential: response.credential }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if(data.status == 1){
                                                let responsePayload = data.pdata;

                                                // Display the user account data
                                                let profileHTML = '<h3>Welcome '+responsePayload.given_name+'! <a href="javascript:void(0);" onclick="signOut('+responsePayload.sub+');">Sign out</a></h3>';
                                                profileHTML += '<img src="'+responsePayload.picture+'"/><p><b>Auth ID: </b>'+responsePayload.sub+'</p><p><b>Name: </b>'+responsePayload.name+'</p><p><b>Email: </b>'+responsePayload.email+'</p>';
                                                document.getElementsByClassName("pro-data")[0].innerHTML = profileHTML;
                                                
                                                document.querySelector("#btnWrap").classList.add("hidden");
                                                document.querySelector(".pro-data").classList.remove("hidden");
                                            }
                                        })
                                        .catch(console.error);
                                    }

                                    // Sign out the user
                                    function signOut(authID) {
                                        document.getElementsByClassName("pro-data")[0].innerHTML = '';
                                        document.querySelector("#btnWrap").classList.remove("hidden");
                                        document.querySelector(".pro-data").classList.add("hidden");
                                    }    
                                </script>

                                <!-- Sign In With Google button with HTML data attributes API -->
                                <div id="g_id_onload"
                                    data-client_id="147613768576-7g0621s87copo0e98i6ht9rdtiru9q3f.apps.googleusercontent.com"
                                    data-context="signin"
                                    data-ux_mode="popup"
                                    data-callback="handleCredentialResponse"
                                    data-auto_prompt="false">
                                </div>

                                <div class="g_id_signin"
                                    data-type="standard"
                                    data-shape="rectangular"
                                    data-theme="outline"
                                    data-text="signin_with"
                                    data-size="large"
                                    data-logo_alignment="left">
                                </div>

                                <!-- Display the user's profile info -->
                                <div class="pro-data hidden"></div>
                                <div class="text-center">

                                <hr>
                                
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