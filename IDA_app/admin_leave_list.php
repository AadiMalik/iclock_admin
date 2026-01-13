<?php 
include"config.php";

if(isset($_POST['admin_id'])){ $admin_id= $_POST['admin_id']; }

  $qry = mysqli_query($conn,"select * from leave_application where admin_id='$admin_id' ORDER BY status ASC");// and delete_status='0'
  
  $result = array();
  
		while($row = mysqli_fetch_array($qry)){
//	echo '<pre>'; print_r($row);
            $qry1 = mysqli_query($conn,"select * from employees where eid='".$row['employee_id']."'");
              $row1 = mysqli_fetch_array($qry1);
	
	
			array_push($result,array(
				'id'=>$row['id'],
				'admin_id'=>$row['admin_id'],
				 'from_date'=>$row['from_date'],
				'to_date'=>$row['to_date'],
				'reason'=>$row['reason'],
				 'status'=>$row['status'],
				 'leavetype_status'=>$row['leavetype_status'],
				 'added_date'=>$row['added_date'],
				 'firstname'=>$row1['firstname'],
				 'lastname'=>$row1['lastname'],
			));
		}


echo json_encode(array('result'=>$result));
 ?>