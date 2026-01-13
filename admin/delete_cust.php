<?php

  ob_start();
  include("connect.php");
  if(isset($_GET['cust_id']))
      {
          $query1=mysqli_query($conn, "UPDATE customer SET status='1' WHERE id='".$_GET['cust_id']."'");
          if($query1)
          {          
              header('location:mng_cust.php');
          }
      }
  ob_end_flush();

?>