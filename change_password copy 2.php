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

                    // Check if form has been submitted
                    if (isset($_POST['submit'])) {
                        // Get form data

                        $new_password = $_POST['new_password'];
                        $confirm_password = $_POST['confirm_password'];

                        // Validate the passwords
                        if ($new_password != $confirm_password) {
                            $error = "Passwords do not match";
                        } elseif (strlen($new_password) < 8) {
                            $error = "Password must be at least 8 characters long";
                        }

                        // Hash password
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                        // Update carousel item in database
                        $query = "UPDATE users SET password='$hashed_password' WHERE id=$id";
                        mysqli_query($conn, $query);

                        // Show success message
                        echo '<div class="alert alert-success">Password Changed successfully!</div>';
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
                                    <label>Userame</label>
                                    <input readonly="" type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>">
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













