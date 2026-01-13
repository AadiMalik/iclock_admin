<?php
require "config.php";
$school_mobile = $_POST["school_mobile"];
$sql=mysqli_query($conn,"select * from admin where username='$school_mobile'");
$row=mysqli_fetch_assoc($sql);
  //while($row=mysqli_fetch_assoc($sql))
 $sql1=mysqli_query($conn,"select COUNT(id) AS cnt from leave_application where admin_id='".$row['id']."' and status ='0'");
 $row1=mysqli_fetch_assoc($sql1);
    $row['pending_approval']=$row1['cnt'];
  $output[]=$row;
  
  json_encode($output);
  print(json_encode($output));
 // mysql_close();
?>