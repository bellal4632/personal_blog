<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../inc/config.php";


// determine current page number
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// set how many cards to display per page
$cards_per_page = 6;

// calculate the limit and offset values for the SQL query
$limit = $cards_per_page;
$offset = ($page - 1) * $cards_per_page;

// For Articles Details
$q = "select * from articles where active='3' ORDER BY created_at desc LIMIT $limit OFFSET $offset";
$r = $conn->query($q);

// for date
$query1 = "SELECT DATE_FORMAT(created_at, '%d %M %Y') AS date_only FROM articles;";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);

?>


<?php require "inc/head.php"; ?>
</head>

<body>
    <!-- Responsive navbar-->
    <?php require "inc/navbar.php"; ?>


    <!-- Carousel Start -->
    <?php require "inc/carousel.php"; ?>
    <!-- Carousel End -->

    <!-- Page content-->
    <div class="container-fluid">
        <div class="row m-2">
            <!-- Blog entries-->
            <div class="col-lg-9">
                <!-- Featured blog post-->
                <?php require "inc/featured.php"; ?>
                <!-- Blog post-->
                <div class="row">
                    <?php
                    while ($row = $r->fetch_assoc()) {
                    ?>
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <img height="220px" src="../a.assets/article_image/<?php echo $row["images"]; ?>" class="card-img-top" alt="...">
                                <div style=" font-size: 15px; text-align: justify; height:90px; display: flex; align-items: center;" class="card-header"><b>
                                        <a class="link-dark" style="text-decoration:none" href="details.php?id=<?= $row['id'] ?>"> <?php echo implode(' ', array_slice(explode(' ', $row['title']), 0, 9)); ?> </a></b>
                                </div>
                                <div class="card-body">
                                    <small>
                                        <p style="text-align: justify; height:105px; display: flex; align-items: center;" class="card-text"><?php echo implode(' ', array_slice(explode(' ', $row['description']), 0, 30)); ?>...
                                        </p>
                                    </small>
                                </div>
                                <div class="card-footer ">
                                    <small class="text-muted">
                                        <p class="mt-2" style="float: left; display: flex; align-items: center;">
                                            <b><?php echo $row1["date_only"]; ?></b>
                                        </p>
                                        <a style="float: right; display: flex; align-items: center;" class="btn btn-primary" href="details.php?id=<?= $row['id'] ?>">Read more →</a>
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
                // create pagination links
                echo '<div class="container">';
                echo '<ul class="pagination justify-content-center">';

                // determine how many pages there are
                $total_pages = ceil($conn->query("SELECT COUNT(*) FROM articles")->fetch_row()[0] / $cards_per_page);

                // display "Newer" button if not on first page
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Newer</a></li>';
                }

                // display page numbers
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item';
                    if ($i == $page) {
                        echo ' active';
                    }
                    echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }

                // display "Older" button if not on last page
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Older</a></li>';
                }

                echo '</ul>';
                echo '</div>';
                ?>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-3">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget-->
                <?php require "inc/category.php"; ?>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Login</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to
                        use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer-->
    <?php require "inc/footer.php"; ?>
</body>

</html>