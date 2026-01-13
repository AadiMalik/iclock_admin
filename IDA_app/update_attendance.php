<?php
include"config.php";

$result = $_POST['result']; 
$atten_type= $_POST['atten_type']; 

date_default_timezone_set('Asia/Calcutta'); 
 $curr_time = date("H:i:s");
 
 $date = date("Y-m-d");
 
$exp=explode(',',$result);
$emp=explode(':',$exp[0]);
$emp_id=$emp[1];

$admin=explode(':',$exp[1]);
$admin_id=$admin[1];

$ename=explode(':',$exp[2]);
$emp_name=$ename[1];
//echo 'admin ID '.$admin_id.'emp ID'.$emp_id.' Name : '.$emp_name;

 $sqle=mysqli_query($conn,"SELECT * FROM employees WHERE eid = '$emp_id'");
 $rowe=mysqli_fetch_assoc($sqle);
if(mysqli_num_rows($sqle) > 0){
    
    if($atten_type=="timein")  {
        
        $sql1=mysqli_query($conn,"select * from attendance where admin_id='$admin_id' and employee_id='$emp_id' and date='$date' and time_in IS NOT NULL");
        $row1=mysqli_fetch_assoc($sql1);
        
        if(mysqli_num_rows($sql1)>0){
        
            if($row1['daytype'] != 'Regular'){
                 echo "Today Leave Approved already ,Not allow to Time In ".$emp_name;
            }
            else{
                 echo "You have timed in for today already ".$emp_name;
            }
               
           
        }else{
            $sql= mysqli_query($conn,"INSERT INTO attendance (id,admin_id,employee_id,date,time_in,status,daytype,num_hr)VALUES
            	('','$admin_id','$emp_id','$date','$curr_time','0.5','Regular','0')"); 
             if($sql)
    		{
    		echo 'Time In :'.$emp_name;
    		}
    		else
    		{
    		 echo 'Failure';
    		 }
        }
    }
    else {
       
        $sql1=mysqli_query($conn,"SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.employee_id = '$emp_id' AND date = '$date'");
        $row1=mysqli_fetch_assoc($sql1);
        
        if(mysqli_num_rows($sql1)< 1){
            
            	 echo 'Cannot Timeout. No time in.'.$emp_name;
        }
        else{
        if($row1['time_out'] != '00:00:00'){
            
           /*   if($row1['daytype'] != 'Regular'){
                     echo 'Today Leave Approved already ,Not allow to Time Out '.$emp_name;
                }
                else{*/
                     echo 'You have timed out for today already '.$emp_name;
                //}
            
           
        }else{
        
             $Sql_Query1 = mysqli_query($conn,"UPDATE attendance SET time_out='$curr_time' WHERE id='".$row1['uid']."'");
              if($Sql_Query1)
    		{
    		 echo 'Time out:'.$emp_name;
    		 
        		 $sql2=mysqli_query($conn,"select * from attendance where id = '".$row1['uid']."'");
                 $urow=mysqli_fetch_assoc($sql2);
                  
                     $time_in = $urow['time_in'];
        			$time_out = $urow['time_out'];
        			
        		 $sql3=mysqli_query($conn,"SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$emp_id'");
                 $srow=mysqli_fetch_assoc($sql3);
                  
                  
                  	if($srow['time_in'] > $urow['time_in']){
        					$time_in = $srow['time_in'];
        			}
        
        			if($srow['time_out'] < $urow['time_out']){
        					$time_out = $srow['time_out'];
        			}
        			
        			$time_in = new DateTime($time_in);
        			$time_out = new DateTime($time_out);
        			//$interval = $time_in->diff($time_out);
        			$interval = $time_in->diff($time_out);
        			$hrs = $interval->format('%h');
        			$mins = $interval->format('%i');
        			$mins = $mins/60;
        			$int = $hrs + $mins;
        					 if($int < 6.5)
        					 {
        							  $status = 0.5;
        					 }
        					else
        					{
        							   $status = 1;	
        					}
                $Sql_Query2 = mysqli_query($conn,"UPDATE attendance SET status = '$status',num_hr = '$int' WHERE id = '".$row1['uid']."'");
                  
        		}
    		else
    		{
    		 echo 'Failure';
    		 }
    		 
            }
        }
        
    }
}
else{
    echo 'Employee ID not found';
}
	
 ?>
 
 