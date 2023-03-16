<?php
require "adminauth.php";
require "config.php";
$id = $_GET['id'];
// Get the value of the row from the form
$row_value = $_POST['active'];

// Check if the row value is 2
if ($row_value == 2) {
  // If the row value is 2, don't update and redirect to users.php
  header("Location: ../users_pending.php");
  exit();
} else {
  // If the row value is not 2, update the row to 2 and redirect to users.php
  $sql = "UPDATE users SET active = '2' WHERE `users`.`id` ='$id' limit 1";
  mysqli_query($conn, $sql);

  header("Location: ../users_pending.php");
  exit();
}
?>