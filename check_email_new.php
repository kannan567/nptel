<?php
include 'includes/config.php';

$query = "SELECT emailid from users WHERE emailid='".$_GET['emailid']."' AND status=0";
$result = mysqli_query($conn, $query);
mysqli_num_rows($result);

if (mysqli_num_rows($result) > 0) {
  echo "false";
}else{
  echo "true";
}
