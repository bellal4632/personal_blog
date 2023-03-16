<?php
require "adminauth.php";
require "config.php";
$id = $_GET['id'];
// Get the value of the row from the form
$row_value = $_POST['active'];

// Check if the row value is 3
if ($row_value == 3) {
  // If the row value is 3, don't update and redirect to users.php
  header("Location: ../users_pending.php");
  exit();
} else {
  // If the row value is not 3, update the row to 3 and redirect to users.php
  $sql = "UPDATE users SET active = '3', role= '1' WHERE `users`.`id` ='$id'";
  mysqli_query($conn, $sql);

  header("Location: ../users_pending.php");
  exit();
}
?>