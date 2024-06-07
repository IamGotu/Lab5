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

                                    <div class="modal-footer">
                                        <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
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