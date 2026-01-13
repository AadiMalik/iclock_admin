<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['id'])!="")
  {
  $delete=$_GET['id'];
  $delete=mysqli_query($conn,"DELETE FROM overtime WHERE id='$delete'");
  if($delete)
  {
      header("Location:overtime.php");
  }
  else
  {
      echo mysqli_error();
  }
  }
  ob_end_flush();

?>