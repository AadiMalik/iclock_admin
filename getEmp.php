<?php
	if(isset($_POST['emp_id'])){
		$output = array('error'=>false);

		include 'connect.php';
		include 'timezone.php';

		$emp_id = $_POST['emp_id'];
		
	      	if($emp_id!='')
	      	{
	      		$sql = "SELECT * FROM employees WHERE employee_id = '".$emp_id."' and expiry_date>='".date('Y-m-d')."'";
				$query = $conn->query($sql);
				$row = $query->fetch_assoc();
				$admin_id = $row['admin_id'];
				$output['admin_id'] = $admin_id;
	      	}
	      	
	      else{
				$output['error'] = true;
				$output['message'] = 'Employee ID is not match';
			}
		
		
	}
	
	echo json_encode($output);

?>