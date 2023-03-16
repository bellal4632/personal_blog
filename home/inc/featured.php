<div class="card mb-4">

    <?php
    $query = "SELECT * FROM articles WHERE featured=2 ORDER BY RAND() LIMIT 1";    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $query1 = "SELECT DATE_FORMAT(created_at, '%d %M %Y') AS date_only FROM articles;";
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    ?>

    <a href="#!"><img height="300px" class="card-img-top" src="../a.assets/article_image/<?php echo $row["images"]; ?>" alt="..." /></a>
    <div class="card-body">
        <div class="small text-muted mb-2 "><?php echo $row1["date_only"]; ?></div>
        <h2 class="card-title"><?php echo implode(' ', array_slice(explode(' ', $row['title']), 0, 9)); ?></h2>
        <p class="card-text"><?php echo implode(' ', array_slice(explode(' ', $row['description']), 0, 35)); ?>...</p>
        <a class="btn btn-primary" href="#!">Read more →</a>
    </div>
</div>

