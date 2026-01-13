<?php 
	 date_default_timezone_set('Asia/kolkata');
      include('connect.php');
	  include("header.php");
      include("sidebar.php");
      if(isset($_POST['save']))
      {
           
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
       
        // print_r($_POST['from_date']);die;
        if($_POST['day']==0.5)
	      	{
	      		$from_date=$to_date=date('Y-m-d',strtotime($_POST['date']));
            	$leave_type=$_POST['leave_type'];
	      	}
	      	else
	      	{
	      		$from_date=date('Y-m-d',strtotime($_POST['from_date']));
	      		$to_date=date('Y-m-d',strtotime($_POST['to_date']));
            	$leave_type=$_POST['leave_type'];
	            if($leave_type=='')
	            {
	              echo '<script>window.alert("Please Select Leave Type.");</script>';
	            }
	      	}
      	if($from_date!='' && $to_date!='' && $leave_type!='')
      	{

      		$sql = "SELECT * FROM employees WHERE eid = '".$_POST['employee_id']."'";
	        $query = $conn->query($sql);
	        $row1 = $query->fetch_assoc();
	        $eid = $row1['eid'];
	        $adminid=$row1['admin_id'];
	         $firstname = $row1['firstname'];
	         $lastname = $row1['lastname'];
	        $department_id = $row1['department_id'];
	        $allot_leave= $row1['allot_leave'];
	        $avail_leave= $row1['avail_leave'];
	        $leave_diff = $row1['leave_difference'];
	        $employee=$row1['employee_id'];
	        $sick_avail_leave = $row1['sick_avail_leave'];
	        $emp_vacation_leaves = $row1['vacation_leaves'];
	        $emp_maternity_leaves = $row1['maternity_leaves'];
	        $emp_paternity_leaves = $row1['paternity_leaves'];
	        $emp_off_leaves = $row1['off_leaves'];
	        $emp_absence_leaves = $row1['absence_leaves'];
	        $amt = $row1['rate'];


      		$sql_insert_cust = mysqli_query($conn,"INSERT INTO `leave_application`( `employee_id`, `admin_id`, `from_date`, `to_date`, `reason`,`leavetype_status`,`leave_type`, `added_date`,`status`,`department_status`,`comment`) VALUES('".$_POST['employee_id']."', '".$_SESSION['id']."', '".$from_date."', '".$to_date."', '".$_POST['reason']."', '".$_POST['day']."', '".$leave_type."','".date('Y-m-d')."',1,1,'".$_POST['comment']."')");
          $last_id = $conn->insert_id;
          if($_POST['day']==0.5)
          {
          	$sq1 ="INSERT INTO half_attendance(leave_app_id,admin_id,department_id,employee_id,date,status,daytype,time_in,time_out,approve_status) VALUES ('$last_id','".$_SESSION['id']."','".$department_id."','".$_POST['employee_id']."','$from_date','".$_POST['day']."','Half Day', '".$_POST['time_in']."', '".$_POST['time_out']."',1)";
            $qu1 = mysqli_query($conn,$sq1);
          }
          $res_date = getDatesFromRange($from_date, $to_date); 
	       // $period = new DatePeriod(new DateTime($from_date),new DateInterval('P1D'),new DateTime($to_date));
	        $day=$_POST['day'];

	        if($leave_type!='half_day')
	        {
	            if($leave_type!='sick_leaves')
	                {
	                    $sql2 = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND name='".$leave_type."' AND delete_status=0 ";
	                    $query2 = $conn->query($sql2);
	                    $row2 = $query2->fetch_assoc();
	                    $avail_leave_type = $row2['no_of_days'];

	                    $sql3 = "SELECT count(*) as cnt FROM attendance WHERE employee_id='".$_POST['employee_id']."' AND YEAR(date)='".date('Y')."' ";
	                    $query3 = $conn->query($sql3);
	                    $row3 = $query3->fetch_assoc();
	                    $emp_count = $row3['cnt'];
	        
	                    if($emp_count==0)
	                    {
	                        if($avail_leave_type<count($res_date))
	                        {
	                            $lwp_leave=count($res_date)-$avail_leave_type;
	                            $lp_leave=$avail_leave_type;
	        
	                        }
	                        else
	                        {
	                            $lp_leave=$avail_leave_type-count($res_date);
	                        }
	                    }
	                    else
	                    {
	                        if($emp_count<count($res_date))
	                        {
	                            $lwp_leave=count($res_date)-$emp_count;
	                            $lp_leave=$avail_leave_type-$emp_count;
	        
	                        }
	                        else
	                        {
	                            $lp_leave=$emp_count-count($res_date);
	                        }
	                    }
	                    
	                }
	                else
	                {
	                    if($sick_avail_leave>=count($res_date))
	                    {
	                        $lwp_leave=count($res_date)-$sick_avail_leave;
	                        $lp_leave=$sick_avail_leave;
	                        $s1 = "UPDATE employees SET sick_avail_leave='0' WHERE employee_id = '".$employee."'";
	                        $q1 = mysqli_query($conn,$s1);
	        
	                    }
	                    else
	                    {
	                        $lp_leave=$sick_avail_leave-count($res_date);
	                        $s1 = "UPDATE employees SET sick_avail_leave='".$lp_leave."' WHERE employee_id = '".$employee."'";
	                            $q1 = mysqli_query($conn,$s1);
	                    }
	                }
	               
	                $i=1;
	                foreach ($res_date as $value) {
	                   $sq1 ="INSERT INTO attendance(admin_id,department_id,employee_id,date,status,daytype) VALUES ('".$_SESSION['id']."','$department_id','$eid','$value','".$day."','$leave_type')";
	                     $qu1 = mysqli_query($conn,$sq1);
	                    if($i>$lp_leave)
	                    {
	                        $sd ="INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','".$employee."','$value','$day','$amt')";
	                        $qd = mysqli_query($conn,$sd);
	                    }
	                    $i++;
	                    }
	        }
	        else
	        {
	            $leave_date=$date=$from_date;  
	            $sql = "SELECT * FROM emp_leave WHERE employee = '".$employee."'";
	            $query = $conn->query($sql);
	            if($query->num_rows < 1)
	            {
	            $sq ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','".$employee."','$leave_date','".$day."')";
	            $qu = mysqli_query($conn,$sq);

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
	            echo 'record not found'; exit;

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

	            $amt = $rate/2;

	            $sd ="INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','".$employee."','$date','$day','$amt')";
	            $qd = mysqli_query($conn,$sd);

	            }  

	            }
	            }
	        }
	        }
	         $adrow1 = $conn->query("SELECT username FROM admin WHERE id = '".$_SESSION['id']."' limit 1")->fetch_array();
	       // $adsql = "SELECT username FROM admin WHERE id = '".$_SESSION['id']."'";
// 			$result = mysqli_query($conn,$adsql);
// 			$adrow1 = $result->fetch_assoc();
	        //$adquery = $conn->query($adsql);
	        //$adrow1 = $adquery->fetch_assoc();
	           
			     $to = $adrow1['username'];
                $subject = "Leave application Notification";
    //             $txt = "
				// Employee Name :  $firstname $lastname <br>
				// Applied for a :  $leave_type <br>
				// Local Leave. :    $day <br>
				// On : ".$_POST['from_date']." to ".$_POST['to_date']."
				// ";
                // $headers = "From: ida@idamru.com" . "\r\n";

                // mail($to,$subject,$txt,$headers);
                
                

$message ="
<html>
<head>
<title>Leave application Notification</title>
</head>
<body>
<p>Dear Admin,<br>
This is a notification that employee name: $firstname,$lastname  applied for leave for 
<<".$_POST['from_date'].">> to <<".$_POST['to_date'].">> . Kindly approve/accept leave in order to update your attendance report for the appropriate date.</p>
<table>
<tr>
<th></th>
<th></th>
</tr>
<tr>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <noreply@iclock.mu>' . "\r\n";

mail($to,$subject,$message,$headers);
                
                
                
                
                
                
                
                
                
                
                
                
                
                
              
        }
      	else
      	{
      		echo '<script>window.alert("Please Insert Proper Date format.");</script>';
      	}
      	
      }
   
?>
   <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Leave</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Leave</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->	
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post">
                                        
										<?php include('connect.php'); ?>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-employee">Employee</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="employee_id" id="val-employee" required>
                                                    <option value="" selected>Please select</option>
                                                    <?php
													  $sql = "SELECT * FROM employees WHERE admin_id='".$_SESSION['id']."'";
													  $query = mysqli_query($conn,$sql);
													  while($row = mysqli_fetch_assoc($query)){
														echo "
														  <option value='".$row['eid']."'>".$row['firstname'].' '.$row['lastname']."</option>
														";
													  }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
										
										
										
										
										 <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-daytype">First Select Day Type</label>
                                            <div class="col-lg-6 ">
                                                <select name="day" id="day" class="form-control custom-select" required>
                                                   <option>--Select--</option>
                                                   <option value="0.5">Half Day</option>
                                                   <option value="1">Full Day</option>
                                                   <option value="1">Permission</option>
                                                </select>
                                            </div>
                                        </div> 
                                         <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="leave_type">Leave Type</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="leave_type" id="leave_type" required>
                                                    <option value="" selected>Please select</option>
                                                    <?php
                                                    $result5 = $conn->query("SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0");
										
                										while($row5=mysqli_fetch_array($result5))
                										{
                						                            	 echo "<option value='".$row5['id']."'>".$row5['name']."</option>"; 
                										    
                										}
                										
                							             ?>
                							 
												<option value="sick_leaves">Sick Leave</option>
												<option value="half_leave">Half Leave</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="half_day" style="display: none;">
                                        	<div class="form-group row">
	                                            <label class="col-lg-4 col-form-label" for="val-date">Date </label>
	                                            <div class="col-lg-6">
	                                                <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control"  name="date">
	                                            </div>
	                                        </div>
                                          <div class="form-group row">
                                              <label class="col-lg-4 col-form-label" for="val-date">From Time</label>
                                              <div class="col-lg-6">
                                                  <input type="time" class="form-control"  name="time_in">
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-lg-4 col-form-label" for="val-date">To Time </label>
                                              <div class="col-lg-6">
                                                  <input type="time" class="form-control"  name="time_out">
                                              </div>
                                          </div>
                                        </div>
                                        <div id="full_day" style="display: none;">
             <!--                             <div class="form-group row">-->
             <!--                               <label class="col-lg-4 col-form-label" for="val-daytype">Leave Type</label>-->
             <!--                               <div class="col-lg-6 ">-->
             <!--                                   <select name="leave_type" id="leave_type" class="form-control custom-select">-->
             <!--                                   	<option value="">Select Leave Type</option>-->
                                               	<?php 
            //          									$sql = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0";
												// 		$result = $conn->query($sql);
												// while($row=mysqli_fetch_array($result)){
												  ?>
             <!--                                     <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>-->
                                            		<?php 
            //  } 
             ?>
             <!--                                       <option value="sick_leaves">Sick Leave</option>-->
             <!--                                   </select>-->
             <!--                               </div>-->
             <!--                           </div>-->
                                        	<div class="form-group row">
	                                            <label class="col-lg-4 col-form-label" for="val-date">From Date </label>
	                                            <div class="col-lg-6">
	                                                <input type="date" max="<?php echo date('Y-m-d',strtotime("+10 day")) ?>" class="form-control"  name="from_date">
	                                            </div>
	                                        </div>
	                                        <div class="form-group row">
	                                            <label class="col-lg-4 col-form-label" for="val-date">To Date </label>
	                                            <div class="col-lg-6">
	                                                <input type="date" max="<?php echo date('Y-m-d',strtotime("+10 day")) ?>" class="form-control"  name="to_date">
	                                            </div>
	                                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Reason </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="reason" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Comment </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="comment" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="save">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
			<?php include("footer.php"); ?>
			<script>
				$('#day').change(function() {
					var day=$('#day').val();
					if(day==0.5)
					{
						$('#half_day').show();
						$('#full_day').hide();
					}
					else
						{
						$('#half_day').hide();
						$('#full_day').show();
					}
				})
			</script>