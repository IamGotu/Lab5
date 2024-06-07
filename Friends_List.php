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
                <h1 class="m-0">Friends</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Friends</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    <!-- Your HTML code -->
                    <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Birthdate</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Active</th>
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
                                                <td><?php echo $row['full_name']; ?></td>
                                                <td><?php echo $row['birthdate']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone_number']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['Active']; ?></td>
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
<?php include('includes/footer.php'); ?>