<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['item_id']))
      {
        $id=$_GET['item_id'];
        $query1=mysqli_query($conn, "UPDATE item SET status='1' WHERE id='$id'");
        if($query1)
          {
            header('location:add_quotation.php');
          }
      }
  ob_end_flush();

?>