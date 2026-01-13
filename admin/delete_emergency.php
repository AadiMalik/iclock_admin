<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['emer_task_id']))
      {
        $id=$_GET['emer_task_id'];
        $query1=mysqli_query($conn, "UPDATE tbl_emergency SET status='1' WHERE emer_task_id='$id'");
        if($query1)
          {
          header('location:emergencytasklist.php');
          }
      }
  ob_end_flush();

?>