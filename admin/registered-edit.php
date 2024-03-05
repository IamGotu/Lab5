<?php
include('Authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/db_conn.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit - Registered User</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit - Registered User</h3>
                            <a href="registered.php" class="btn btn-danger btn-sm float-right">Back</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="home.php" method="POST">
                                        <div class="modal-body">
                                            <?php
                                                if(isset($_GET['user_id']))
                                                {
                                                    $user_id = $_GET['user_id'];
                                                    $query = "SELECT * FROM user_profile WHERE user_id='$user_id' LIMIT 1";
                                                    $query_run = mysqli_query($conn, $query);

                                                    if(mysqli_num_rows($query_run) > 0)
                                                    {
                                                        foreach($query_run as $row)
                                                        {
                                                            ?>
                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                                                                <div class="form-group">
                                                                    <label for="">Full Name</label>
                                                                    <input type="text" name="full_name" value="<?php echo $row['full_name'] ?>" class="form-control" placeholder="Full Name">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Email</label>
                                                                    <input type="text" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Email">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Phone Number</label>
                                                                    <input type="text" name="phone_number" value="<?php echo $row['phone_number'] ?>" class="form-control" placeholder="Phone Number">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Address</label>
                                                                    <input type="text" name="address" value="<?php echo $row['address'] ?>" class="form-control" placeholder="Address">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Password</label>
                                                                    <input type="password" name="password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Password">
                                                                </div>
                                                            <?php
                                                        }
                                                    } 
                                                    else
                                                    {
                                                        echo "<h4>No Record Found.!<h4>";
                                                    } 
                                                }
                                            ?>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="UpdateUser" class="btn btn-info">Update</button>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>