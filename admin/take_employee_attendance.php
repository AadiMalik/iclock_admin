<?php
	if(isset($_POST['employee'])){
		$output = array('error'=>false);

		include 'connect.php';
		include 'timezone.php';

		$employee = $_POST['employee'];
		$remark = $_POST['remark'];
		$status = $_POST['status'];

		if($status=='in' || $status=='out')
		{
			$query = $conn->query("SELECT * FROM employees WHERE employee_id = '".$employee."' AND   isActive='0' and expiry_date>='".date('Y-m-d')."' limit 1");
			

				if($query->num_rows > 0){
					$row = $query->fetch_assoc();
					$id = $row['eid'];
		            $fnm = $row['firstname'];
					$lnm = $row['lastname'];
					$date_in = $_POST['timeInDate'];
					
		            $now=$_POST['Time'];
		            $admin_id = $row['admin_id'];
		            $department_id = $row['department_id'];
		            
					if($status == 'in'){
				// 		$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
					$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_in' AND time_in IS NOT NULL AND time_out='00:00:00' ";
						$query = $conn->query($sql);
						if($query->num_rows > 0){
							$output['error'] = true;
							$output['message'] = 'You have timed in for today first Time out for today';
						}
						else{
					$sql = "INSERT INTO attendance (admin_id,department_id,employee_id, date, time_in, status, daytype,time_in_remark) VALUES ('$admin_id','$department_id','$id', '$date_in','$now' ,'0.5','Regular','$remark')";
							if($conn->query($sql)){
								$output['message'] = 'Time in: '.$row['firstname'].' '.$row['lastname'];
							}
							else{
								$output['error'] = true;
								$output['message'] = $conn->error;
							}
						}
					}
					else{
					    $date_out = $_POST['timeOutDate'];
					    if($date_in==null)
					    {
					      $output['error'] = true;
						  $output['message'] = 'Time IN Date is required';  
					    }
					    else
					    {
					       	$sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id 
					       	WHERE attendance.employee_id = '$id' AND date = '$date_in' AND time_out='00:00:00'";
						$query = $conn->query($sql);
						if($query->num_rows < 1){
							$output['error'] = true;
							$output['message'] = 'Cannot Timeout. No time in.';
						}
						else{
							while($row = $query->fetch_assoc())
							{
				// 			if($row['time_out'] != '00:00:00'){
				// 				$output['error'] = true;
				// 				$output['message'] = 'You have timed out for today';
				// 			}
				// 			else{
								$attendanceId=$row['uid'];
								$sql = "UPDATE attendance SET time_out = '".$now."',time_out_remarks = '$remark' WHERE id='$attendanceId'";
								if($conn->query($sql)){
									$output['message'] = 'Time out:'.$row['firstname'].' '.$row['lastname'];
									
									$sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
									$query = $conn->query($sql);
									$urow = $query->fetch_assoc();

									$time_in = $urow['time_in'];
									$time_out = $urow['time_out'];

									$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$id'";
									$query = $conn->query($sql);
									$srow = $query->fetch_assoc();

									//if($srow['time_in'] > $urow['time_in']){
										$db_time_in = $srow['time_in'];
									//}

									//if($srow['time_out'] < $urow['time_out']){
										$db_time_out = $srow['time_out'];
									//}


                                $time_in = new DateTime($time_in);
								$time_out = new DateTime($time_out);
                                if($date_in==$date_out)
                                {
                                   
									$interval = $time_in->diff($time_out);
								
  
                                }
                                else
                                {
                                   
									//$interval = $time_in->diff($time_out);
									$interval1 = $time_in->diff('23:59:59');
									$interval2 = '23:59:59'->diff($time_out);
								$interval=$interval1+$interval2;

									
                                }
									
									
										
									$hrs = $interval->format('%h');
									$mins = $interval->format('%i');
									$mins = $mins/60;
									$int = round($hrs + $mins,2);
									
									$db_time_in = new DateTime($db_time_in);
									$db_time_out = new DateTime($db_time_out);
									$db_interval = $db_time_in->diff($db_time_out);
									$db_hrs = $db_interval->format('%h');
									$db_mins = $db_interval->format('%i');
									$db_mins = $db_mins/60;
									$db_int =  round($db_hrs + $db_mins,2);  
								    if($int < $db_int)
									   $status = 0.5;
									else
									   $status = 1;
									$sql = "UPDATE attendance SET status = '$status',num_hr = '$int' WHERE id = '".$row['uid']."'";
									$conn->query($sql);
								}
								else{
									$output['error'] = true;
									$output['message'] = $conn->error;
								}
							}
							
						} 
					    }
					
					}
				}
				else{
					$output['error'] = true;
					$output['message'] = 'Employee ID not found';
				}
		}
	}
	
	echo json_encode($output);

?>