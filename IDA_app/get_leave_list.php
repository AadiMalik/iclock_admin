<?php 
include"config.php";

if(isset($_POST['eid'])){ $eid= $_POST['eid']; }

  $qry = mysqli_query($conn,"select * from leave_application where employee_id='$eid' ORDER BY status ASC");// and delete_status='0'
  
  $result = array();
  
		while($row = mysqli_fetch_array($qry)){
//	echo '<pre>'; print_r($row);
	
			array_push($result,array(
				'id'=>$row['id'],
				'admin_id'=>$row['admin_id'],
				 'from_date'=>$row['from_date'],
				'to_date'=>$row['to_date'],
				'reason'=>$row['reason'],
				 'status'=>$row['status'],
				 'leavetype_status'=>$row['leavetype_status'],
				 'added_date'=>$row['added_date'],
				 
			));
		}


echo json_encode(array('result'=>$result));
 ?>