<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Categories</title>
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

                        // get the values from the form
                        $title = $_POST["title"];
                        $description = $_POST["desc"];
                        $tag = $_POST["tag"];

                        // insert the data into the database
                        $sql = "INSERT INTO categories (name, description, icon) VALUES ('$title', '$description', '$tag')";
                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            New Category Added Successfully!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button></div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert"
                            >Error: ' . $sql . '<br>' . $conn->error . ' 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button></div>';
                        }

                        // close the database connection
                        $conn->close();
                    }
                    ?>


                    <form class="row g-3 needs-validation" method="post" novalidate>
                        <div class="col-md-3">

                            <input type="text" class="form-control" placeholder="Category Title" id="title" name="title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please Enter A Category Title.
                            </div>
                        </div>
                        <div class="col-md-4">

                            <input type="text" class="form-control" placeholder="Category Description" id="desc" name="desc" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please Enter A Category Description.
                            </div>
                        </div>
                        <div class="col-md-4">

                            <input type="text" class="form-control" placeholder="Fontawesome Icon Tag" id="tag" name="tag" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please Enter A Category Icon Tag.
                            </div>
                        </div>
                        <div class="col-md-1 align-self-end mt-2">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                    </form>
                    <hr>


                    <br>
                    <h5 class="mb-3">All Categories</h5>


                    <table class="table  table-bordered table-striped table align-middle table-success table-hover">
                        <thead style="text-align: center;" class="">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Icon</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connect to your database
                            require "inc/config.php";

                            // Query to get the total number of rows
                            $result = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM categories");

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
                            $result = mysqli_query($conn, "SELECT * FROM categories order by created_at desc LIMIT 5 OFFSET $offset");
// for date
$query1 = "SELECT DATE_FORMAT(created_at, '%d %M %Y') AS date_only FROM categories;";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);

                            // Loop through the rows and display them in the table
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr style='text-align: center;'>";
                                echo "<td class='col-md-2'>" . $row['name'] . "</td>";
                                echo "<td class='col-md-4'>" . $row['description'] . "</td>";
                                echo "<td class='col-md-1'>" . $row['icon'] . "</td>";
                                echo "<td class='col-md-2'>" . $row1['date_only'] . "</td>";
                                echo '<td class="col-md-1">


                                <div class="btn-group" role="group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      Actions
    </button>
    <ul class="dropdown-menu bg-dark">
      <li><a class="dropdown-item text-info" href="category-edit.php?id=' . $row['id'] . '"><b>Edit</b></a></li>
      <li><a class="dropdown-item text-warning" href="category-edit.php?id=' . $row['id'] . '"><b>Deactive</b></a></li>
      <li><a class="dropdown-item text-danger" href="category-delete.php?id=' . $row['id'] . '"><b>Delete</b></a></li>
    </ul>
  </div>

                                   
                                  </td>';


                                echo "</tr>";
                            }

                            // Close the database connection
                            mysqli_close($conn);
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