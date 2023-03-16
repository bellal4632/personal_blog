<?php
require "adminauth.php";
require "config.php";
$id = $_GET['id'];
// Get the value of the row from the form
$row_value = $_POST['role'];

// Check if the row value is 3
if ($row_value == 3) {
  // If the row value is 3, don't update and redirect to users.php
  header("Location: ../users.php");
  exit();
} else {
  // If the row value is not 3, update the row to 3 and redirect to users.php
  $sql = "UPDATE users SET role = '3' WHERE `users`.`id` ='$id' limit 1";
  mysqli_query($conn, $sql);

  header("Location: ../users.php");
  exit();
}
?>