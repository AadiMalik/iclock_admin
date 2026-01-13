<?php session_start();
//Connect to database
include('connect.php');

$output = '';

if(isset($_POST["To_Excel"])){
  


      $output .= '
                  <table class="table" bordered="1">  
				  <tr>
				  <th>Date</th>
				  <th>Day</th>
				  <th>Department Name</th>
				  <th>Employee ID</th>
				  <th>Name</th>
				  <th>Time In</th>
				  <th>Time In Remark</th>
				  <th>Time Out</th>
				  <th>Time Out Remark</th>
				  <th>Hrs</th>
				  <th>Day Type</th>
				 
			</tr>';
			                            $employid = $_POST['emp_name'];
										$dpt=$_POST['dept'];
											 $range = $_POST['date_range'];
											 $ex = explode(' - ', $range);
										  $from = date('Y-m-d', strtotime($ex[0]));
											 $to = date('Y-m-d', strtotime($ex[1]));
										   if($_POST['emp_name'])
										   {
												   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.eid='$employid' ORDER BY attendance.date DESC, attendance.time_in DESC";
										   }
										   else if($dpt!=='all' && $dpt!==''){
												$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' ORDER BY attendance.date DESC, attendance.time_in DESC";
											 
											}
										   else
										   if($_POST['dept']=='all')
										   {
											   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";
										}
										
// 
									   
									   else 
									   {
										//$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE  employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";
										
										  $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND attendance.date<='".date('Y-m-d')."' ORDER BY attendance.date DESC, attendance.time_in DESC";
									   }
									   
									   $result = $conn->query($sql);
		//	$result = $conn->query($sql);
			while($row=mysqli_fetch_array($result)){
				
				extract($row);
			
			
		 $id = $row['eid'];
		 $e=$row['empid'];
		 $aid= $row['attid'];
		 $date=date('M d, Y', strtotime($row['date']));
		 $emp_id = $row['employee_id'];
		 $emp_fname = $row['firstname'];
		 $emp_lname = $row['lastname'];
		 $fulname=$emp_fname." ".$emp_lname;
		 $timein = date('h:i A', strtotime($row['time_in']));
		 $timeout=date('h:i A', strtotime($row['time_out']));
		 $daytype=$row['daytype'];
		  $dsql = "SELECT * FROM department WHERE id = '".$row['department_id']."'";
		  
			$dquery = $conn->query($dsql);
			$drow = $dquery->fetch_assoc();
			if(!empty($drow))
			{
				$department_name = $drow['department_name'];
			}
			else
			{
				$department_name ='';
			}
		
			$hsql = "SELECT * FROM half_attendance WHERE date = '".$row['date']."' AND employee_id='".$row['eid']."' AND approve_status=1";
			$hquery = $conn->query($hsql);
			$hrow = $hquery->fetch_assoc();
			if(!empty($hrow))
			{
				$half = '<span class="label label-danger pull-right">Absent in <br>'.date('h:i a', strtotime($hrow['time_in'])).' - '.date('h:i a', strtotime($hrow['time_out'])).'</span>';
			}
			else
			{
				$half ='';
			}

			$numhrr=number_format((float)$row['num_hr'], 2, '.', '');
			$timestamp = strtotime($date); 
			$tda= $day=date("l", $timestamp);
            $output .= '
                        <TR> 
                            <TD> '.$date.'</TD>
                            <TD> '.$tda.'</TD>
                            <TD> '.$department_name.'</TD>
                            <TD> '.$emp_id.'</TD>
                            <TD> '.$fulname.'</TD>
                            <TD> '.$timein.'</TD>
                            <TD> '.$row['time_in_remark'].'</TD>
                            <TD> '.$timeout.'</TD>
                            <TD> '.$row['time_out_remark'].'</TD>
							<TD> '.$numhrr.'</TD>
							<TD> '.$daytype.'<br>'.$half.'</TD>
							
                        </TR>';
        }
        $output .= '</table>';
        // echo $output;die;
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=Attendance.xls');
        
        echo $output;
       
        exit();
}
    else{
       header( "location: attendance.php" );
      exit();
    }
?>