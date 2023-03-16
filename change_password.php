<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Change Password</title>
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- !-- Sidebar -->
        <?php require "inc/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require "inc/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 text-gray-800">Change Password</h1>
                    <hr>

                    <?php
                    $id = $_GET['id'];

                    // Include database connection
                    include 'inc/config.php';

                    // Initialize variables for alerts
                    $error_msg = '';
                    $success_msg = '';

                    // Check if form is submitted
                    if (isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {

                        // Get current user ID
                        $id = $_GET['id'];

                        // Sanitize user inputs
                        $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
                        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
                        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

                        // Get current user password from database
                        $sql = "SELECT password FROM users WHERE id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $password = $row['password'];


                        // Verify current password
                        if (password_verify($current_password, $password)) {

                            // Check if new password matches confirm password
                            if ($new_password === $confirm_password) {

                                // Hash new password
                                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                                // Update password in database
                                $sql = "UPDATE users SET password = '$new_password_hash' WHERE id = '$id'";
                                if (mysqli_query($conn, $sql)) {
                                    // Set success message
                                    $success_msg = 'Password changed successfully.';
                                } else {
                                    // Set error message
                                    $error_msg = 'Error changing password.';
                                }
                            } else {
                                // Set error message
                                $error_msg = 'New password and confirm password do not match.';
                            }
                        } else {
                            // Set error message
                            $error_msg = 'Incorrect current password.';
                        }
                    }
                    // Select carousel item data from database
                    $query = "SELECT * FROM users WHERE id = $id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);


                    ?>


                    <?php if (!empty($error_msg)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_msg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success_msg)) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_msg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="username">Name</label>
                                        <input type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" readonly="" name="name">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" value="<?php echo $row['username']; ?>" readonly="" name="username">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="username">Email</label>
                                        <input type="text" class="form-control" id="email" value="<?php echo $row['email']; ?>" readonly="" name="email">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="new_password">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>
</body>

</html>