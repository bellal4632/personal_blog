<?php
require "adminauth.php";
require "config.php";
$id = $_GET['id'];
// Get the value of the row from the form
$row_value = $_POST['active'];

// Check if the row value is 2
if ($row_value == 2) {
  // If the row value is 2, don't update and redirect to article_list.php
  header("Location: ../article_list.php");
  exit();
} else {
  // If the row value is not 2, update the row to 2 and redirect to article_list.php
  $sql = "UPDATE articles SET active = '2' WHERE `articles`.`id` ='$id' limit 2";
  mysqli_query($conn, $sql);

  header("Location: ../article_list.php");
  exit();
}
?>