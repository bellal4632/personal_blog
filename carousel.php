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
                    <h1 class="h3 text-gray-800">Categories</h1>
                    <hr>
                    <h5>Add Category</h5>

                    <?php
                    // check if form is submitted
                    if (isset($_POST['submit'])) {
                        // connect to the database
                        require "inc/config.php";

                        // Form submission
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Get form data
                            $title_1 = $_POST['title_1'];
                            $title_2 = $_POST['title_2'];
                            $title_3 = $_POST['title_3'];

                            // Upload images to server

                            $image_1 = null;
                            if (isset($_FILES['image_1'])) {
                                $im1 = $_FILES['image_1'];
                                $image_1 = uniqid() . ".png";
                                move_uploaded_file($_FILES['image_1']['tmp_name'], 'a.assets/carousel/' . $image_1);
                            }
                            $image_2 = null;
                            if (isset($_FILES['image_2'])) {
                                $im2 = $_FILES['image_2'];
                                $image_2 = uniqid() . ".png";
                                move_uploaded_file($_FILES['image_2']['tmp_name'], 'a.assets/carousel/' . $image_2);
                            }

                            $image_3 = null;
                            if (isset($_FILES['image_3'])) {
                                $im3 = $_FILES['image_3'];
                                $image_3 = uniqid() . ".png";
                                move_uploaded_file($_FILES['image_3']['tmp_name'], 'a.assets/carousel/' . $image_3);
                            }
                            // Insert data into database
                            $sql = "INSERT INTO carousel (title_1, image_1, title_2,  image_2, title_3, image_3)
            VALUES ('$title_1', '$image_1', '$title_2', '$image_2', '$title_3', '$image_3')";

                            if (mysqli_query($conn, $sql)) {
                                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                 Images uploaded successfully!
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>';
                            } else {
                                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                 Error uploading images: ' . mysqli_error($conn) . '
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>';
                            }
                        }
                    }
                    ?>

                    <?php if (isset($alert)) {
                        echo $alert;
                    } ?>

                    <form class="row g-2 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                        <div class="col-md-4">
                            <div class="col mb-2">
                                <input type="text" class="form-control" placeholder="First Slider Title" id="title_1" name="title_1" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter First Slider Title.
                                </div>
                            </div>
                            <div class="col mb-2">
                                <input name="image_1" type="file" class="form-control" aria-label="file example" required>
                                <div class="invalid-feedback">Please Select Image For First Slider</div>
                            </div>



                        </div>
                        <div class="col-md-4">
                            <div class="col mb-2">
                                <input type="text" class="form-control" placeholder="Second Slider Title" id="title_2" name="title_2" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Second Slider Title.
                                </div>
                            </div>
                            <div class="col mb-2">
                                <input name="image_2" type="file" class="form-control" aria-label="file example" required>
                                <div class="invalid-feedback">Please Select Image For Second Slider</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col mb-2">
                                <input type="text" class="form-control" placeholder="Third Slider Title" id="title_3" name="title_3" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Third Slider Title.
                                </div>
                            </div>
                            <div class="col mb-2">
                                <input name="image_3" type="file" class="form-control" aria-label="file example" required>
                                <div class="invalid-feedback">Please Select Image For Third Slider</div>
                            </div>
                        </div>
                        <div class="col-md-1 align-self-end m-2">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                    </form>
                    <hr>


                    <br>
                    <h5 class="mb-3">All Categories</h5>


                    <table class="table  table-bordered table-striped table align-middle table-success table-hover">
                        <thead style="text-align: center;" class="">
                            <tr>
                                <th>Title One</th>
                                <th>Image One</th>
                                <th>Title Two</th>
                                <th>Image Two</th>
                                <th>Title Three</th>
                                <th>Image Three</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connect to your database
                            require "inc/config.php";

                            // Query to get the total number of rows
                            $result = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM carousel");

                            // Get the total number of rows
                            $row = mysqli_fetch_assoc($result);
                            $total_rows = $row['total_rows'];

                            // Calculate the total number of pages
                            $total_pages = ceil($total_rows / 5);

                            // Get the current page from the URL
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            // Calculate the offset for the current page
                            $offset = ($page - 1) * 5;

                            // Query your database to get the rows for the current page
                            $result = mysqli_query($conn, "SELECT * FROM carousel order by create_at desc LIMIT 5 OFFSET $offset");

                            // Check if select was successful
                            if (mysqli_num_rows($result) > 0) {
                                // Fetch data and display in table
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr style="text-align: center; ">';
                                    echo '<td class="col-md-2">' . $row['title_1'] . '</td>';
                                    echo '<td><img src="a.assets/carousel/' . $row['image_1'] . '" width="150px"></td>';
                                    echo '<td class="col-md-2">' . $row['title_2'] . '</td>';
                                    echo '<td><img src="a.assets/carousel/' . $row['image_2'] . '" width="150px"></td>';
                                    echo '<td class="col-md-2">' . $row['title_3'] . '</td>';
                                    echo '<td><img src="a.assets/carousel/' . $row['image_3'] . '" width="150px"></td>';
                                    echo '<td class="col-md-1">
                                <a href="carousel-edit.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm my-2">Edit</a>
                                
                                <a href="carousel-delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm my-2">Delete</a>
                              </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr style="text-align: center;"><td colspan="7">No data found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                // Display the pagination links
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>


            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (() => {
                    'use strict'

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    const forms = document.querySelectorAll('.needs-validation')

                    // Loop over them and prevent submission
                    Array.from(forms).forEach(form => {
                        form.addEventListener('submit', event => {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
                })()
            </script>

</body>

</html>