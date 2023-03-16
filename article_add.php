<?php
require "inc/config.php";
require "inc/adminauth.php";
if (isset($_POST['submit'])) {
    $title = $conn->escape_string($_POST['atitle']);
    $desc = $conn->escape_string($_POST['adesc']);
    $cat = $_POST['acat'];
    $tag = $_POST['atag'];
    $image = null;
    if (isset($_FILES['aimage'])) {
        $im = $_FILES['aimage'];
        $image = uniqid() . ".png";
        move_uploaded_file($_FILES['aimage']['tmp_name'], 'a.assets/article_image/' . $image);
    }
    $iq = "insert into articles values(null,'" . $cat . "','" . $title . "','" . $desc . "','" . $image . "','1','" . $_SESSION['userid'] . "','" . $tag . "','',null)";

    $conn->query($iq);
    if ($conn->affected_rows) {
        $message = "Article Added Successfully!";
    }

    

                        

}

$q = "select * from categories where 1";
$r = $conn->query($q);
?>


<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Add Article</title>
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
                    <h1 class="h3 text-gray-800">Add Article</h1>
                    <hr>

                    

                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="atitle" class="form-label">Title</label>
                                    <input type="text" class="form-control" placeholder="Type Your Title Of Your Arcticle" name="atitle" id="atitle" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        required
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adesc" class="form-label">Description</label>
                                    <textarea style="min-height: 100px;" name="adesc" id="adesc" placeholder="Type The Details Of Your Article" class="form-control"></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        required
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-4 mb-3 mb-sm-2">
                                        <label for="aimage" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="aimage" name="aimage" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            required
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-2">
                                        <label for="acat" class="form-label">Category</label><br>
                                        <select name="acat" id="acat" class="form-select" aria-label="Default select example">
                                            <option selected disabled value="">Choose Article Category</option>
                                            <?php
                                            while ($row = $r->fetch_assoc()) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            required
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-2">
                                        <label for="atag" class="form-label">Tags</label>
                                        <input type="text" class="form-control" placeholder="Type Relative Tags Of Your Article" name="atag" id="atag" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            required
                                        </div>
                                    </div>
                                </div>



                                <button style="float: left;" class="btn btn-primary my-2" type="submit" name="submit">Publish Article</button>

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