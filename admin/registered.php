<?php
include('Authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/db_conn.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<!-- User Modal-->
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="home.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <span></span>
                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" required>
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>

                    
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="AddUser" class="btn btn-primary">Save</button>
            </div>
            </form> 
        </div>
    </div>
</div>

<!-- Delete User -->
<div class="modal fade" id="DeletModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="home.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="delete_id" class="delete_user_id">
                    <p>
                        Are you sure, you want to delete this data?
                    </p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="DeleteUserbtn" class="btn btn-primary">Yes, Delete.!</button>
            </div>
            </form> 
        </div>
    </div>
</div>
<!-- Delete User -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Friends List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Friends List</li>
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
                    <?php
                        if (isset($_SESSION['status']))
                        {
                            echo "<h4>".$_SESSION['status']."<h4>";
                            unset($_SESSION['status']);
                        }
                    ?>
                    
                    <!-- Your HTML code -->
                    <?php
                    if(isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                        unset($_SESSION['error']); // Clear the error message after displaying it
                    }
                    ?>

                    <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM user_profile";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        while($row = mysqli_fetch_assoc($query_run))
                                        {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['full_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone_number']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td>
                                                    <a href="registered-edit.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                    <button type="button" value="<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm deletebtn">Delete</button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="6">No Record Found</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    
</div>

<?php include('includes/script.php'); ?>

<script>
    $(document).ready(function() {
        $('.deletebtn').click(function(e) {
            e.preventDefault();
        
            var user_id = $(this).val();
            //console.log(user_id);
            $('.delete_user_id') .val (user_id);
            $('#DeletModal') .modal ('show');
        });
    });
</script>

<?php include('includes/footer.php'); ?>