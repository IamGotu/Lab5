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