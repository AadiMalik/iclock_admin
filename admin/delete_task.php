<?php
  ob_start();
  include("connect.php");
  if(isset($_GET['task_id']))
      {
        $id=$_GET['task_id'];
        $query1=mysqli_query($conn, "UPDATE tbl_task SET status='1' WHERE id='$id'");

        if($query1)
        {
          $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE id='$id'");
          $row = mysqli_fetch_array($results);

          $query2=mysqli_query($conn, "UPDATE assign_task_module SET status='1' WHERE task_id='".$row['task_id']."'");

            if($query2)
              header('location:task_list.php');
        }
      }
  ob_end_flush();

?>