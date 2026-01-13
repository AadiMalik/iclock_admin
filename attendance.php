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
					$date_now = date('Y-m-d');
		            $now=date('H:i:s');
		            $admin_id = $row['admin_id'];
		            $department_id = $row['department_id'];
		            // =============================
        // CHECK IF EMPLOYEE IS ON LEAVE
        // =============================
        $leave_check = $conn->query("SELECT * FROM leave_application 
                                     WHERE employee_id = '$id' 
                                       AND status = 1 
                                       AND '$date_now' BETWEEN from_date AND to_date
                                     LIMIT 1");
        if($leave_check->num_rows > 0){
            $output['error'] = true;
            $output['message'] = 'You cannot check in/out because you are on leave today.';
            echo json_encode($output);
            exit; // stop further execution
        }
        // =============================

        // --- EXISTING IN / OUT LOGIC CONTINUES ---
					if($status == 'in'){
				// 		$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
					$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL AND time_out='00:00:00' ";
						$query = $conn->query($sql);
						if($query->num_rows > 0){
							$output['error'] = true;
							$output['message'] = 'You have timed in for today first Time out for today';
						}
						else{
					$sql = "INSERT INTO attendance (admin_id,department_id,employee_id, date, time_in, status, daytype,time_in_remark) VALUES ('$admin_id','$department_id','$id', '$date_now','$now' ,'0.5','Regular','$remark')";
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
					    $timeInDate=$_POST['timeInDate'];
					    if($timeInDate==null)
					    {
					      $output['error'] = true;
						  $output['message'] = 'Time IN Date is required';  
					    }
					    else
					    {
					       	$sql = "SELECT attendance.id AS uid FROM attendance WHERE employee_id = '$id' AND date =  '$timeInDate' AND time_out like '%00:00:00%'";
						$query = $conn->query($sql);
						if($query->num_rows < 1){
							$output['error'] = true;
							$output['message'] = 'Cannot Timeout. NO time in.'.$id.'-'.$timeInDate.' '.$query->num_rows;
						}
						else{
							while($row = $query->fetch_array())
							{
				// 			if($row['time_out'] != '00:00:00'){
				// 				$output['error'] = true;
				// 				$output['message'] = 'You have timed out for today';
				// 			}
				// 			else{
								$attendanceId=$row['uid'];
								$sql1 = $conn->query("UPDATE attendance SET time_out = '".$now."',time_out_remarks = '$remark' WHERE id='$attendanceId'");
								if($sql1)
								{
									//$output['message'] .= 'Time out:'.$fnm.' '.$lnm;
									
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
                                if($timeInDate==$date_now)
                                {
                                   
									$interval = $time_in->diff($time_out);
								
  
                                }
                                else
                                {
                                     $sett=new DateTime('23:59:59');
									$interval = $time_in->diff($time_out);
								//	$output['message'] .= ' '.$interval; 
								$interval1 = $time_in->diff($sett);
								$interval2 = $sett->diff($time_out);
								//$interval=$interval1+$interval2;
                              
									
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
							
								$output['message'] .=' '.$fnm.' '.$lnm.'<br>Time Out '.$now.' :<br>Time In Date: ' .$timeInDate; 
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
		else if($status=='apply_leave' && isset($_POST['day']) && isset($_POST['passwd']))
		{
			$passw = hash('sha256', $_POST['passwd']);
		    //$passw = hash('sha256',$p);
		    //echo $passw;exit;
		    function createSalt()
		    {
		        return '2123293dsj2hu2nikhiljdsd';
		    }
		    $salt = createSalt();
		    $pass = hash('sha256', $salt . $passw);

			$sql = "SELECT * FROM employees WHERE employee_id = '".$employee."' AND password = '". $pass."'  AND isActive='0' AND expiry_date>='".date('Y-m-d')."'";
				$query = $conn->query($sql);
			if($query->num_rows > 0){
					$row = $query->fetch_assoc();
					$id = $row['eid'];
		            $fnm = $row['firstname'];
					$lnm = $row['lastname'];
					$date_now = date('Y-m-d');
		            $now=date('H:i:s');
		            $admin_id = $row['admin_id'];
		            $department_id = $row['department_id'];
			if($_POST['day']==0.5)
	      	{
	      		$from_date=$to_date=date('Y-m-d',strtotime($_POST['date']));
	      		$leave_type='half_day';
	      	}
	      	else
	      	{
	      		$from_date=date('Y-m-d',strtotime($_POST['from_date']));
	      		$to_date=date('Y-m-d',strtotime($_POST['to_date']));
	      		$leave_type=$_POST['leave_type'];
	      	}
	      	if($from_date!='' && $to_date!='' && $leave_type!='')
	      	{
	      		$sql_insert_cust = mysqli_query($conn,"INSERT INTO `leave_application`( `employee_id`, `admin_id`, `from_date`, `to_date`, `reason`,`leavetype_status`,`leave_type`, `added_date`) VALUES('".$id."', '".$admin_id."', '".$from_date."', '".$to_date."', '".$_POST['reason']."', '".$_POST['day']."', '".$leave_type."','".date('Y-m-d')."')");
	      		$last_id = $conn->insert_id;
	          if($_POST['day']==0.5)
	          {
	          $sq1 ="INSERT INTO half_attendance(leave_app_id,admin_id,department_id,employee_id,date,status,daytype,time_in,time_out) VALUES ('$last_id','".$admin_id."','".$department_id."','".$id."','$from_date','".$_POST['day']."','Half Day', '".$_POST['time_in']."', '".$_POST['time_out']."')";
	            $qu1 = mysqli_query($conn,$sq1);
	          }
				$output['message'] = 'Your Request Applied Successfully';

				$s = "select * from email_mng";
          $r = $conn->query($s);
          $rr = mysqli_fetch_assoc($r);

          $mail_host = $rr['mail_driver_mail_host'];
          $mail_name = $rr['name'];
          $mail_username = $rr['mail_username'];
          $mail_password = $rr['mail_password'];
          $mail_port = $rr['mail_port'];

          $s1 = "select * from admin WHERE id='".$admin_id."'";
          $r1 = $conn->query($s1);
          $rr1 = mysqli_fetch_assoc($r1);

          $s2 = "select * from employees WHERE eid='".$id."'"; 
          $r2 = $conn->query($s2);
          $rr2 = mysqli_fetch_assoc($r2);

          $message=$rr2['firstname']." ".$rr2['lastname']." is applied leave application from ".$from_date." to ".$to_date." date";

          require("admin/PHPMailer/class.phpmailer.php");
              $mail = new PHPMailer();
              $mail->IsSMTP();
              $mail->Host = $mail_host;
              $mail->From = $rr1['username'];
              $mail->FromName  =  $mail_name;
              $mail->AddAddress($rr1['username']);
              $mail->SMTPAuth = "true";
              $mail->Username = $mail_username;
              $mail->Password =  $mail_password;
              $mail->Port  =  $mail_port;
              $mail->Subject = 'New Leave Application';
              $mail->Body = $message;
              $mail->Send();
	      	}
	      	else
	      	{
	      		$output['error'] = true;
				$output['message'] = 'Please Insert Proper Date format or select leave type';
	      	}
	      }
	      else{
				$output['error'] = true;
				$output['message'] = 'Employee ID or PIN no are not match';
			}
		}
		
		
	}
	
	echo json_encode($output);

?>