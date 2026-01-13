<?php
require "config.php";
$school_mobile = $_POST["school_mobile"];
$sql=mysqli_query($conn,"select * from employees where employee_id='$school_mobile'");
$row=mysqli_fetch_assoc($sql);
//  while($row=mysqli_fetch_assoc($sql))
 $sql1=mysqli_query($conn,"select description from position where id='".$row['position_id']."'");
 $row1=mysqli_fetch_assoc($sql1);
    $row['position']=$row1['description'];
  $output[]=$row;
  
  json_encode($output);
  print(json_encode($output));
 // mysql_close();
?>