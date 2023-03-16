<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - Pending Users</title>
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
                    <h1 class="h3 text-gray-800">Pending/Deativated Users</h1>


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
                        $cards_per_page = 15;

                        // calculate the limit and offset values for the SQL query
                        $limit = $cards_per_page;
                        $offset = ($page - 1) * $cards_per_page;

                        $result = mysqli_query($conn, "SELECT * FROM users WHERE active NOT IN (3) ORDER BY id LIMIT $limit OFFSET $offset");
                        
                        // Loop through all users and create a card for each one
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                            <div class="col mb-3 ">
                                <div class="card border-dark h-100">
                                    <img height="220px" src="a.assets/pro_image/<?php echo $row["pro_image"]; ?>" class="card-img-top" alt="<?= $row['name'] ?>">
                                    <div class="card-header"><b>
                                            <?= $row['name'] ?></b>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-3"><b>Name</b></div>
                                            <div class="col-md-9">
                                                <h6><?= $row['username'] ?></h6>
                                            </div>
                                            <div class="col-md-3"><b>E-mail</b></div>
                                            <div class="col-md-9">
                                                <h6><?= $row['email'] ?></h6>
                                            </div>
                                            <div class="col-md-3"><b>Phone</b></div>
                                            <div class="col-md-9">
                                                <h6><?= $row['phone'] ?></h6>
                                            </div>
                                            <div class="col-md-3"><b>Role</b></div>
                                            <div class="col-md-9">
                                                <h6>
                                                    <?php if ($row["role"] == 1) {
                                                        echo "Publisher";
                                                    } elseif ($row["role"] == 2) {
                                                        echo "Moderator";
                                                    } elseif ($row["role"] == 3) {
                                                        echo "Admin";
                                                    } elseif ($row["role"] == 4) {
                                                        echo "Temporary Deactivated";
                                                    } ?>
                                                    </h6>
                                            </div>

                                        </div>




                                    </div>
                                    <div class="card-footer d-flex justify-content-center px-1">
                                        <small class="text-muted">



                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                


                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn <?php if ($row["active"] == 1) {
                                                                                            echo "btn-warning";
                                                                                        } elseif ($row["active"] == 2) {
                                                                                            echo "btn-danger";
                                                                                        } elseif ($row["active"] == 3) {
                                                                                            echo "btn-success";
                                                                                        } elseif ($row["role"] == 4) {
                                                                                            echo "btn-danger";
                                                                                        } ?>         
                                                    dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <?php if ($row["active"] == 1) {
                                                            echo "Pending";
                                                        } elseif ($row["active"] == 2) {
                                                            echo "Declined";
                                                        } elseif ($row["active"] == 3) {
                                                            echo "Approved";
                                                        } elseif ($row["active"] == 4) {
                                                            echo "Temporary Deactivated";
                                                        } ?>

                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        
                                                        <li><a class="dropdown-item text-success" href="inc/user_approve.php?id=<?= $row['id'] ?>"><b>Approve</b></a></li>
                                                        <li><a class="dropdown-item text-danger" href="inc/user_decline.php?id=<?= $row['id'] ?>"><b>Decline</b></a></li>
                                                    </ul>
                                                </div>
                                                
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
                    echo '<div class="container my-2">';
                    echo '<ul class="pagination justify-content-center">';
                    $pages = ceil($conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] / $cards_per_page);
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