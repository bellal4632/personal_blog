<div id="carouselId" class="carousel slide" data-bs-ride="carousel">

  <?php

  $sql_query = "SELECT * FROM carousel ORDER BY create_at DESC limit 1";
  $result = $conn->query($sql_query);
  $result = $result->fetch_assoc();
  ?>

  <ol class="carousel-indicators">
    <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
    <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
    <li data-bs-target="#carouselId" data-bs-slide-to="2" aria-label="Third slide"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
    <img height="300px" src="../a.assets/carousel/<?= $result['image_1'] ?>" class="w-100 d-block" alt="<?= $result['title_1'] ?>">
      <div class="carousel-caption d-none d-md-block">
        <h5 style="color:black;"><?= $result['title_1'] ?></h5>
      </div>
    </div>
    <div class="carousel-item">
      <img height="300px" src="../a.assets/carousel/<?= $result['image_2'] ?>" class="w-100 d-block" alt="<?= $result['title_2'] ?>">
      <div class="carousel-caption d-none d-md-block">
        <h5 style="color:black;"><?= $result['title_2'] ?></h5>
      </div>
    </div>
    <div class="carousel-item">
    <img height="300px" src="../a.assets/carousel/<?= $result['image_3'] ?>" class="w-100 d-block" alt="<?= $result['title_3'] ?>">
      <div class="carousel-caption d-none d-md-block">
        <h5 style="color:black;"><?= $result['title_3'] ?></h5>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>