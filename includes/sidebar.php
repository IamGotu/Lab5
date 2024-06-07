<?php
include('config/db_conn.php'); // Include your database connection

// Assuming you have validated the user's login credentials
$user_id = $_SESSION['auth_user']['user_id']; // Use the logged-in user's ID

$query = "SELECT profile_picture FROM user_profile WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $profile_picture);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    // Store the profile picture in the session
    $_SESSION['auth_user']['profile_picture'] = $profile_picture;
}
?>


<!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
if(isset($_SESSION['auth_user'])) {
    $fullName = isset($_SESSION['auth_user']['full_name']) ? $_SESSION['auth_user']['full_name'] : 'Unknown';
} else {
    $fullName = "Not Logged in";
}
?>

<a href="User_Profile.php" class="brand-link">
  <?php
    // Set a default profile picture if not logged in or no picture is available
    $profilePicture = isset($_SESSION['auth_user']['profile_picture']) && $_SESSION['auth_user']['profile_picture'] != "" ? $_SESSION['auth_user']['profile_picture'] : 'uploads/avatar.png';
  ?>
  <img src="<?php echo 'uploads/' . $profilePicture; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light"><?php echo isset($fullName) ? $fullName : 'Guest'; ?></span>
</a>


      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="Dashboard.php" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="Friends_List.php" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Friends
              </p>
            </a>
          </li>
          
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>