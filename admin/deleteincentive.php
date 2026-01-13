<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['id'])!="")
  {
  $delete=$_GET['id'];
  $delete=mysqli_query($conn,"DELETE FROM incentive WHERE id ='$delete'");
  if($delete)
  {
      header("Location:incentive.php");
  }
  else
  {
      echo mysqli_error();
  }
  }
  ob_end_flush();

?>