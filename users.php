<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>
<title>Admin - All Users</title>
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
                    <h1 class="h3 text-gray-800">All Users</h1>


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

                        $result = mysqli_query($conn, "SELECT * FROM users WHERE active=3 order by role desc LIMIT $limit OFFSET $offset");

                        // for date
$query1 = "SELECT DATE_FORMAT(created_at, '%d %M %Y') AS date_only FROM users;";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);

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
                                            <div class="col-md-4"><b>User Serial</b></div>
                                            <div class="col-md-8">
                                                <h6><?= $row['id'] ?></h6>
                                            </div>
                                            <div class="col-md-4"><b>Username</b></div>
                                            <div class="col-md-8">
                                                <h6><?= $row['username'] ?></h6>
                                            </div>
                                            <div class="col-md-4"><b>E-mail</b></div>
                                            <div class="col-md-8">
                                                <h6><?= $row['email'] ?></h6>
                                            </div>
                                            <div class="col-md-4"><b>Phone</b></div>
                                            <div class="col-md-8">
                                                <h6><?= $row['phone'] ?></h6>
                                            </div>
                                            <div class="col-md-4"><b>Role</b></div>
                                            <div class="col-md-8">
                                                <h6><?php if ($row["role"] == 1) {
                                                        echo "Publisher";
                                                    } elseif ($row["role"] == 2) {
                                                        echo "Moderator";
                                                    } elseif ($row["role"] == 3) {
                                                        echo "Admin";
                                                    } elseif ($row["role"] == 4) {
                                                        echo "Temporary Deactivated";
                                                    } ?></h6>
                                            </div>

                                            <div class="col-md-4"><b>Join At</b></div>
                                            <div class="col-md-8">
                                                <h6><?= $row1['date_only'] ?></h6>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-center px-1">
                                        <small class="text-muted">



                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn <?php if ($row["role"] == 1) {
                                                                                            echo "btn-dark";
                                                                                        } elseif ($row["role"] == 2) {
                                                                                            echo "btn-info";
                                                                                        } elseif ($row["role"] == 3) {
                                                                                            echo "btn-primary";
                                                                                        }  ?>         
                                                    dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <b>
                                                            <?php if ($row["role"] == 1) {
                                                                echo "Publisher";
                                                            } elseif ($row["role"] == 2) {
                                                                echo "Moderator";
                                                            } elseif ($row["role"] == 3) {
                                                                echo "Admin";
                                                            }  ?>
                                                        </b>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item text-danger" href="inc/user_deactive.php?id=<?= $row['id'] ?>"><b>Temporary Deactivate</b></a></li>
                                                        <li><a class="dropdown-item text-dark" href="inc/user_publisher.php?id=<?= $row['id'] ?>"><b>Publisher</b></a></li>
                                                        <li><a class="dropdown-item text-info" href="inc/user_Moderator.php?id=<?= $row['id'] ?>"><b>Moderator</b></a></li>
                                                        <li><a class="dropdown-item text-primary" href="inc/user_admin.php?id=<?= $row['id'] ?>"><b>Admin</b></a></li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-warning" href="change_password.php?id=<?= $row['id'] ?>" role="button">
                                                    <i class="fas fa-key px-2"></i>Change Password</a>
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