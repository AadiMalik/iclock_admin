<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['id'])!="")
  {
  $delete=$_GET['id'];
  $delete=mysqli_query($conn,"DELETE FROM position WHERE id='$delete'");
  if($delete)
  {
      header("Location:position.php");
  }
  else
  {
      echo mysqli_error();
  }
  }
  ob_end_flush();

?>