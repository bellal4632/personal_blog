<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Edit User</title>
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

                    <h1 class="h3 text-gray-800">Edit User</h1>
                    <hr>

                    <?php
                    // Get users item ID from query string
                    $id = $_GET['id'];

                    // Connect to database
                    $conn = mysqli_connect("localhost", "root", "", "project_cms");

                    // Check if form has been submitted
                    if (isset($_POST['submit'])) {
                        // Get form data
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $username = $_POST['username'];
                        $role = $_POST['active'];



                        // check if image is uploaded

                        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                            $image = $_FILES['image']['name'];
                            $tmp_image = $_FILES['image']['tmp_name'];
                            move_uploaded_file($tmp_image, "a.assets/pro_image/$image");
                        } else {
                            // If no new image is uploaded, use the existing one from the database
                            $query = "SELECT * FROM users WHERE id = $id";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $image = $row['pro_image'];
                        }

                        // Update users item in database
                        $query = "UPDATE users SET name='$name', username='$username', email='$email',  phone='$phone', pro_image='$image', role='$role' WHERE id=$id";
                        mysqli_query($conn, $query);

                        // Show success message
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">User Details Updated Successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button></div>';
                    }

                    // Select users item data from database
                    $query = "SELECT * FROM users WHERE id = $id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);



                    ?>


                    <form method="post" enctype="multipart/form-data">

                        <div class="row mb-2">
                            <div class="col-md-8">

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Email</label>
                                        <input value="<?php echo $row['email']; ?>" readonly="" type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="email" name="email">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Username</label>
                                        <input type="text" class="form-control form-control-user" readonly="" id="exampleLastName" name="username" value="<?php echo $row['username']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="active">
                                        <option value="1" <?php echo $row['role'] ? 'selected' : ''; ?>>Publisher</option>
                                        <option value="2" <?php echo !$row['role'] ? 'selected' : ''; ?>>Moderator</option>
                                        <option value="3" <?php echo !$row['role'] ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                            </div>


                            <div class="col-md-4">

                                <img alt="<?php echo $row['pro_image']; ?>" src="a.assets/pro_image/<?php echo $row['pro_image']; ?>" class="img-thumbnail">

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>

</body>

</html>