<?php
include 'includes/config.php';

$query = "SELECT emailid from users WHERE emailid='".$_GET['emailid']."' AND id!=".$_GET['id']." AND status=0";
$result = mysqli_query($conn, $query);
mysqli_num_rows($result);
// echo mysqli_num_rows($result);exit;
if (mysqli_num_rows($result) > 0) {//return 0;
  echo "false";
}else{//return 1;
  echo "true";
}
