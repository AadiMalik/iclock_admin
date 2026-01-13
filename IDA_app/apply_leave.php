<?php
  	include"config.php";
 
 $eid = $_POST['eid'];
 $admin_id = $_POST['admin_id'];
 $fromdate = $_POST['fromdate'];
 $todate = $_POST['todate'];
 $reason = $_POST['reason'];
 $leave_type = $_POST['leave_type'];
 
   $date = date("Y-m-d");
  
		$Sql_Query= mysqli_query($conn,"INSERT INTO leave_application (id,employee_id,admin_id,from_date,to_date,reason,status,leavetype_status,added_date)VALUES
		('','$eid','$admin_id','$fromdate','$todate','$reason','0','$leave_type','$date')"); 
 
		 if($Sql_Query)
		{
		 echo 'Record Updated Successfully';
		}
		else
		{
		 echo 'Something went wrong';
		 }

 ?>
