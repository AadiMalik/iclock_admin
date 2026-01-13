<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['id'])!="")
  {
  $delete=$_GET['id'];
  $delete=mysqli_query($conn,"DELETE FROM attendance WHERE id ='$delete'");
  if($delete)
  {
      header("Location:attendance.php");
  }
  else
  {
      echo mysqli_error();
  }
  }
  ob_end_flush();

?>