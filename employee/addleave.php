<?php
	 date_default_timezone_set('India/Mauritius');
	 include('../connect.php');
	  include("header.php");
      include("sidebar.php");
      if(isset($_POST['save']))
      {
        if($_POST['day']==0.5)
	      	{
	      		$from_date=$to_date=date('Y-m-d',strtotime($_POST['date']));
            $leave_type='half_day';
	      	}
	      	else
	      	{
	      	    $range = $_POST['date_range'];

											 $ex = explode(' - ', $range);

										  $from_date = date('Y-m-d', strtotime($ex[0]));

											 $to_date = date('Y-m-d', strtotime($ex[1]));
											 
	      	// 	$from_date=date('Y-m-d',strtotime($_POST['from_date']));
	      	// 	$to_date=date('Y-m-d',strtotime($_POST['to_date']));
            $leave_type=$_POST['leave_type'];
            if($leave_type=='')
            {
              echo '<script>window.alert("Please Select Leave Type.");</script>';
            }
	      	}
      	if($from_date!='' && $to_date!='' && $leave_type!='')
      	{
      		$sql_insert_cust = mysqli_query($conn,"INSERT INTO `leave_application`( `employee_id`, `admin_id`, `from_date`, `to_date`, `reason`,`leavetype_status`,`leave_type`, `added_date`) VALUES('".$_POST['employee_id']."', '".$_SESSION['admin_id']."', '".$from_date."', '".$to_date."', '".$_POST['reason']."', '".$_POST['day']."', '".$leave_type."','".date('Y-m-d')."')");
          $last_id = $conn->insert_id;
          if($sql_insert_cust)
          {
            $_SESSION['data']="<div class='alert alert-info'>Application Submitted Successfully</div>";  
          }
          else{
               $_SESSION['data']="<div class='alert alert-danger'>Internal Error! ".$conn->error."</div>";  
          }
          if($_POST['day']==0.5)
          {
          $sq1 ="INSERT INTO half_attendance(leave_app_id,admin_id,department_id,employee_id,date,status,daytype,time_in,time_out) VALUES ('$last_id','".$_SESSION['admin_id']."','".$_SESSION['department_id']."','".$_POST['employee_id']."','$from_date','".$_POST['day']."','Half Day', '".$_POST['time_in']."', '".$_POST['time_out']."')";
            $qu1 = mysqli_query($conn,$sq1);
          }
          
          //for sending email
          $s = "select * from email_mng";
          $r = $conn->query($s);
          $rr = mysqli_fetch_assoc($r);

          $mail_host = $rr['mail_driver_mail_host'];
          $mail_name = $rr['name'];
          $mail_username = $rr['mail_username'];
          $mail_password = $rr['mail_password'];
          $mail_port = $rr['mail_port'];

          $s1 = "select * from admin WHERE id='".$_SESSION['admin_id']."'";
          $r1 = $conn->query($s1);
          $rr1 = mysqli_fetch_assoc($r1);

          $s2 = "select * from employees WHERE eid='".$_SESSION['id']."'"; 
          $r2 = $conn->query($s2);
          $rr2 = mysqli_fetch_assoc($r2);

          $message=$rr2['firstname']." ".$rr2['lastname']." is applied leave application from ".$from_date." to ".$to_date." date";

          require("../admin/PHPMailer/class.phpmailer.php");
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
      		echo '<script>window.alert("Please Insert Proper Date format.");</script>';
      	}
      	
      }
   
?>
   <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Apply Leave</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Apply Leave</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
    <?php if(!empty($_SESSION['data']))
    {
        echo $_SESSION['data'];
        unset($_SESSION['data']);
    } ?>
    
  			 <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post">
                                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['id']; ?>">
										
										                    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-daytype">First Select Day Type</label>
                                            <div class="col-lg-6 ">
                                                <select name="day" id="day" class="form-control custom-select" required>
                                                   <option>--Select--</option>
                                                   <option value="0.5">Half Day</option>
                                                   <option value="1">Full Day</option>
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

										   <label class="col-lg-4 col-form-label" for="val-username">Date Range</label>

										   <div class="col-lg-6">

											   <input type="text" id="reservation" class="form-control" name="date_range" required>

										   </div>

									   </div>
									   
                                          <!--<div class="form-group row">-->
                                          <!--    <label class="col-lg-4 col-form-label" for="val-date">From Time</label>-->
                                          <!--    <div class="col-lg-6">-->
                                          <!--        <input type="time" class="form-control"  name="time_in">-->
                                          <!--    </div>-->
                                          <!--</div>-->
                                          <!--<div class="form-group row">-->
                                          <!--    <label class="col-lg-4 col-form-label" for="val-date">To Time </label>-->
                                          <!--    <div class="col-lg-6">-->
                                          <!--        <input type="time" class="form-control"  name="time_out">-->
                                          <!--    </div>-->
                                          <!--</div>-->
                                        </div>
                                        <div id="full_day" style="display: none;">
                                          <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-daytype">Leave Type</label>
                                            <div class="col-lg-6 ">
                                                <select name="leave_type" id="leave_type" class="form-control custom-select">
                                                  <option value="">Select Leave Type</option>
                                                   <?php 
                                                    $sql = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['admin_id']."' AND delete_status=0";
                                                  $result = $conn->query($sql);
                                                while($row=mysqli_fetch_array($result)){
                                                  ?>
                                                  <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                  <?php } ?>
                                                    <option value="sick_leaves">Sick Leave</option>
                                                </select>
                                            </div>
                                        </div>
                                          <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Date Range</label>

										   <div class="col-lg-6">

											   <input type="text" id="reservation" class="form-control" name="date_range" required>

										   </div>

									   </div>
                                        	<!--<div class="form-group row">-->
	                                        <!--    <label class="col-lg-4 col-form-label" for="val-date">From Date </label>-->
	                                        <!--    <div class="col-lg-6">-->
	                                        <!--        <input type="date" min="<?php echo date('Y-m-d',strtotime("+1 day")) ?>" class="form-control"  name="from_date">-->
	                                        <!--    </div>-->
	                                        <!--</div>-->
	                                        <!--<div class="form-group row">-->
	                                        <!--    <label class="col-lg-4 col-form-label" for="val-date">To Date </label>-->
	                                        <!--    <div class="col-lg-6">-->
	                                        <!--        <input type="date" min="<?php echo date('Y-m-d',strtotime("+1 day")) ?>" class="form-control"  name="to_date">-->
	                                        <!--    </div>-->
	                                        <!--</div>-->
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Reason </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="reason" required>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(function() {
  $('input[name="date_range"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>