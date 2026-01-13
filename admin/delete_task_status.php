<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['id']))
      {
        $id=$_GET['id'];
        $query1=mysqli_query($conn, "UPDATE tbl_task_status SET status='1' WHERE id='$id'");
        if($query1)
          {
            header('location:emp_task_status.php');
          }
      }
  ob_end_flush();

?>