<?php
include 'includes/header.php';
include 'includes/config.php';

if(isset($_GET['delete']))
{
  $userid= $_GET['delete'];
  $query = "UPDATE users SET status = 1 WHERE id = $userid";
  $delete_query= mysqli_query($conn, $query);
  header("Location: index.php");
}
?>