<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Pending Articles</title>
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
                    <h1 class="h3 text-gray-800">Pending Articles</h1>
                    <hr>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php
                        // Connect to the database and retrieve all users
                        $conn = mysqli_connect("localhost", "root", "", "project_cms");


                        // determine current page number
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        // set how many cards to display per page
                        $cards_per_page = 9;

                        // calculate the limit and offset values for the SQL query
                        $limit = $cards_per_page;
                        $offset = ($page - 1) * $cards_per_page;

                        $result = mysqli_query($conn, "SELECT * FROM articles WHERE active NOT IN (3) ORDER BY id LIMIT $limit OFFSET $offset");

                            // Fetch data and display in table
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                                <div class="col mb-3 ">
                                    <div class="card border-danger h-100">
                                        <img height="220px" src="a.assets/article_image/<?php echo $row["images"]; ?>" class="card-img-top" alt="...">
                                        <div class="card-header"><b>
                                                <a class="link-dark" style="text-decoration:none" href=""> <?php echo implode(' ', array_slice(explode(' ', $row['title']), 0, 3)); ?> </a></b>
                                        </div>
                                        <div class="card-body">
                                            <small>
                                                <p class="card-text"><?php echo implode(' ', array_slice(explode(' ', $row['description']), 0, 35)); ?>...


                                                </p>
                                            </small>
                                        </div>
                                        <div class="card-footer d-flex justify-content-center">
                                            <small class="text-muted">



                                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                    <a class="btn btn-primary" href="article_edit.php?id=<?= $row['id'] ?>" role="button">
                                                        <i class="fas fa-edit px-2"></i>Edit Article</a>


                                                    <a class="btn btn-success" href="inc/article_publish.php?id=<?= $row['id'] ?>" role="button">
                                                        <i class="fas fa-edit px-2"></i>Publish Aricle</a>


                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }                        
                        ?>
                
                    </div>
                    <!-- // create pagination links -->
                    <?php
                    echo '<div class="row align-items-end my-2">';
                    echo '<ul class="pagination justify-content-center">';
                    $pages = ceil($conn->query("SELECT COUNT(*) FROM articles")->fetch_row()[0] / $cards_per_page);
                    for ($i = 1; $i <= $pages; $i++) {
                        echo '<li class="page-item';
                        if ($i == $page) {
                            echo ' active';
                        }
                        echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>
</body>

</html>