<?php
include('Authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/db_conn.php');
?>

<div class="content-wrapper">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php include('message.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['auth'])): ?>
                            <?php if (isset($_GET['error'])): ?>
                                <p><?php echo $_GET['error'] ?></p>
                            <?php endif ?>
                            <form action="Update_Profile.php" method="POST" enctype="multipart/form-data">

                                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="<?php echo $_SESSION['auth_user']['user_id'] ?>">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" value="<?php echo $_SESSION['auth_user']['full_name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['auth_user']['email'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Phone Number" value="<?php echo $_SESSION['auth_user']['phone_number'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Address" value="<?php echo $_SESSION['auth_user']['address'] ?>">
                                </div>

                                

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" id="profile_picture" name="profile_picture" class="form-control-file">
                                </div>


                                </div>
                                <button type="submit" name="UpdateUser" class="btn btn-info">Update</button>
                            </form>
                        <?php else: ?>
                            <p class="text-danger">You are not logged in.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if (isset($_SESSION['status']))
                        {
                            echo "<h4>".$_SESSION['status']."<h4>";
                            unset($_SESSION['status']);
                        }
                    ?>
                    <?php
                    if(isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                        unset($_SESSION['error']); // Clear the error message after displaying it
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>
