<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>SB Admin 2 - blank</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>


                    <?php
        
                    // Get carousel item ID from query string
                    $id = $_GET['id'];

                    // Connect to database
                    $conn = mysqli_connect("localhost", "root", "", "project_cms");
                    
                    // Initialize variables for alerts
                    $error_msg = '';
                    $success_msg = '';

                    
                    // Check if form has been submitted
                    if (isset($_POST['submit'])) {
                        // Get form data

                        $new_password = $_POST['new_password'];
                        $confirm_password = $_POST['confirm_password'];
                        $current_password = $_POST['current_password'];

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


                    <form method="post" enctype="multipart/form-data">

                        <div class="row mb-2">
                            <div class="col-md-6">


                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" readonly="" class="form-control" name="email" value="<?php echo $row['email']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="new_password">
                                </div>



                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>

                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>
</body>

</html>