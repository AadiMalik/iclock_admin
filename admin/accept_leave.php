<?php
session_start();
date_default_timezone_set('Asia/kolkata');
      include('connect.php');

      $slwp ="SELECT * FROM leave_application WHERE id='".$_GET['id']."'";
				$qlwp = mysqli_query($conn,$slwp);
				$row = mysqli_fetch_assoc($qlwp);
				$res_date = getDatesFromRange($row['from_date'], $row['to_date']); 
				$period = new DatePeriod(new DateTime($row['from_date']),new DateInterval('P1D'),new DateTime($row['to_date']));
				$sql = "SELECT * FROM employees WHERE eid = '".$row['employee_id']."'";
					$query = $conn->query($sql);
					$row1 = $query->fetch_assoc();
					$eid = $row1['eid'];
					$allot_leave= $row1['allot_leave'];
					$avail_leave= $row1['avail_leave'];
					$leave_diff = $row1['leave_difference'];
					$employee=$row1['employee_id'];
					$day=$row['leavetype_status'];
					    foreach ($res_date as $value) {
					    	$sql_attend = "SELECT * FROM attendance WHERE employee_id = '$eid' AND date='".$value."'";
						$query_attend = $conn->query($sql_attend);
					    if($query_attend->num_rows >= 1){
					    }
					    else
					    {
				     $leave_date=$date=$value;  
				     
					$sql = "SELECT * FROM emp_leave WHERE employee = '".$employee."'";
				    $query = $conn->query($sql);
			        if($query->num_rows < 1)
			        {
						$sq ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','".$employee."','$leave_date','".$day."')";
			              $qu = mysqli_query($conn,$sq);
						 if($day==1)
						 {
						 	$sq1 ="INSERT INTO attendance(admin_id,employee_id,date,status,daytype) VALUES ('".$_SESSION['id']."','$eid','$leave_date','".$day."','Leave')";
						 	$qu1 = mysqli_query($conn,$sq1);
						 } 
						
			            
			            
			            $avail_leave = $allot_leave - $day;
					
						$s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
						$q1 = mysqli_query($conn,$s1);
					}
					else
					{	
			
					    $sql = "SELECT * FROM emp_leave WHERE employee = '".$employee."'";
					    $query = $conn->query($sql);
				        if($query->num_rows < 1){
						$sq ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','".$employee."','$value','$day')";
			              $qu = mysqli_query($conn,$sq);
						 if($day==1)
						 { 
								$sq1 ="INSERT INTO attendance(id,admin_id,employee_id,date,status,daytype) VALUES (' ','".$_SESSION['id']."','$eid','$value','$day','Leave')";
					            $qu1 = mysqli_query($conn,$sq1);
					        }
						  $avail_leave = $allot_leave - $day;
							
							$s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
							$q1 = mysqli_query($conn,$s1);
					    }
					    else
						   {
								
								
							$sql1 = "SELECT employee, max(date) as dt FROM emp_leave WHERE employee = '".$employee."'
					                    GROUP BY employee ";
										
							$query1 = mysqli_query($conn,$sql1);
						    if($query1->num_rows < 1){
								echo 'record not found';
								
								}
							else{
								$rows = mysqli_fetch_assoc($query1);
								$emp = $rows['employee'];
								$lastdate= $rows['dt'];
								
						        $pickupDate = new DateTime($lastdate);
					            $returnDate = new DateTime($date);
					            $interval = $pickupDate->diff($returnDate);
					            $days = $interval->format('%a');
								//echo $days;exit;
								
								if($days >= $leave_diff)
								{
					                $s ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','$emp','$date','$day')";
					                $q = mysqli_query($conn,$s);

					                if($day==1)
						 			{
						                $s11 ="INSERT INTO attendance(admin_id,employee_id,date,status,daytype) VALUES ('".$_SESSION['id']."','$eid','$date','$day','Leave')";
						                $q11 = mysqli_query($conn,$s11);
						            }
									
									$avail_leave = $avail_leave - $day;
									
									$s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
									$q1 = mysqli_query($conn,$s1);
									
								}
								else {
									
									$seq = "SELECT * FROM employees WHERE employee_id = '$emp'";
	                                $qs = $conn->query($seq);
									$r = $qs->fetch_assoc();
		                            $e = $r['eid'];
									$rate = $r['rate'];
									
									$amt = $rate * $day;
							  
									$sd ="INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','".$employee."','$date','$day','$amt')";
									$qd = mysqli_query($conn,$sd);
							  
							  		if($day==1)
						 			{
										$slwp ="INSERT INTO attendance(id,admin_id,employee_id,date,status,daytype) VALUES (' ','".$_SESSION['id']."','$e','$date','$day','LWP')";
										$qlwp = mysqli_query($conn,$slwp);
									}
									
								 }  
							
							   }
						    }
					}
				}
				}
					$s1 = "UPDATE leave_application SET status=1 WHERE id = '".$_GET['id']."'";
						$q1 = mysqli_query($conn,$s1);


	function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
    // Declare an empty array 
    $array = array(); 
      
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
    // Use loop to store date into array 
    foreach($period as $date) {                  
        $array[] = $date->format($format);  
    } 
  
    // Return the array elements 
    return $array; 
} 
?>
<script>
	alert('Approved Successfully');
    window.location="approvals.php";
</script>