<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Verification Error</title>
    <link rel="stylesheet" href="Stylesheet.css">
    <!-- Check if the 'error' parameter is set in the URL and display error message-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form class="mt-5">
            <h1 class="mb-4">Email Verification Error</h1>

            <div class="text-center">
            <?php // Check if a custom error message is provided in the URL?>
            <?php if(isset($_GET['message'])) { ?>
                <?php $error_message = $_GET['message']; ?>
                <?php echo "<p>$error_message</p>";?>
            <?php } else { ?>
                <?php // Display a default error message ?>
                <?php echo "<p>There was an error verifying your email. Please make sure you followed the correct verification link.</p>"; ?>
            <?php }?>
            </div>

            <div class="form-group">
                <a href="VerifyEmail.php" class="btn btn-primary">Try Again</a>
            </div>
        </form>
    </div>
</body>
</html>