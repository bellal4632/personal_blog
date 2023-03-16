<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Edit Article</title>
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
                    <h1 class="h3 text-gray-800">Edit Article</h1>
                    <hr>



                    <?php
                    // Get articles item ID from query string
                    $id = $_GET['id'];

                    // Connect to database
                    $conn = mysqli_connect("localhost", "root", "", "project_cms");

                    // Check if form has been submitted
                    if (isset($_POST['submit'])) {
                        // Get form data
                        $title = $_POST['title'];
                        $desc = $_POST['desc'];
                        $cat = $_POST['acat'];


                        // check if image is uploaded
                        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                            $image = $_FILES['image']['name'];
                            $tmp_image = $_FILES['image']['tmp_name'];
                            move_uploaded_file($tmp_image, "a.assets/article_image/$image");
                        } else {
                            // If no new image is uploaded, use the existing one from the database
                            $query = "SELECT * FROM articles WHERE id = $id";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $image = $row['images'];
                        }

                        // Update articles item in database
                        $query = "UPDATE articles SET category_id='$cat', title='$title', description='$desc', images='$image' WHERE id=$id";
                        mysqli_query($conn, $query);

                        // Show success message
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Article Updated Successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button></div>';
                    }

                    // Select articles item data from database
                    $query = "SELECT * FROM articles WHERE id = $id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);


                    $q = "select * from categories where 1";
                    $r = $conn->query($q);
                    ?>


                    <?php if (isset($success)) : ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (isset($row)) : ?>


                        <form method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-8">

                                 <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea style="height: 100px;" name="desc" id="desc" class="form-control"><?= $row['description']; ?></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>


                                    <div class="form-group">
                                        <label for="acat" class="form-label">Category</label>
                                        <select class="form-select" name="acat" id="acat">
                                            <option selected disabled value="">Choose...</option>
                                            <?php
                                            while ($c = $r->fetch_assoc()) {
                                                $selected = $c['id'] == $row['category_id'] ? "selected" : "";
                                                echo "<option value='" . $c['id'] . "' " . $selected . ">" . $c['name'] . "</option>";
                                            }

                                            ?>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Required
                                        </div>
                                    </div>


                                </div>




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Current Image:</label>
                                        <?php if ($row["images"]) : ?>
                                            <img src="a.assets/article_image/<?php echo $row['images']; ?>" class="img-thumbnail">
                                        <?php else : ?>
                                            <p>No image uploaded.</p>
                                        <?php endif; ?>
                                    </div>


                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </form>

                    <?php endif; ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>
</body>

</html>