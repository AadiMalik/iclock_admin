<?php 

	  include('connect.php');

	 include("header.php");

	 include("sidebar.php");

	 error_reporting(1);

?>





<!-- Page wrapper  -->

	   <div class="page-wrapper">

		   <!-- Bread crumb -->

		   <div class="row page-titles">

			   <div class="col-md-5 align-self-center">

				   <h3 class="text-primary">Attendance</h3> </div>

			   <div class="col-md-7 align-self-center">

				   <ol class="breadcrumb">

					   <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>

					   <li class="breadcrumb-item active"> Attendance</li>

				   </ol>

			   </div>

		   </div>

		   <!-- End Bread crumb -->

		   <!-- Container fluid  -->

		   <div class="container-fluid">

			   <!-- Start Page Content -->

			   <div class="row">

				   <div class="col-12">

					   <div class="card">

						   <div class="card-body">

							   <div class="form-validation">

								   <form class="form-valide" action="OverallAttendance.php" method="POST">

									   <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Select Department</label>

										   <div class="col-lg-6">

											   <select class="form-control"  id="dept-drop" name="dept">

												   <option value="all">All</option>

												   <?php 

												   $sql = "SELECT * FROM department where delete_status=0 AND admin_id='".$_SESSION['id']."'";

												   $result = $conn->query($sql);

												   while($row=mysqli_fetch_array($result)){ ?>

													   <option value="<?php echo $row['id'] ?>"><?php echo $row['department_name'] ?></option>

												   <?php } ?>

											   </select>

										   </div>

									   </div>



									   <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Date Range</label>

										   <div class="col-lg-6">

											   <input type="text" id="reservation" class="form-control" name="date_range" required>

										   </div>

									   </div>

									   

									   <div class="form-group row">

										   <div class="col-lg-8 ml-auto">

											   <button type="submit" class="btn btn-primary" name="show_record">Submit</button>

										   </div>

									   </div>

								   </form>

							   </div>



						   </div>

					   </div>

					   <div class="card">

						   <div class="card-body">

						       

							   <div class="table-responsive m-t-40">

								   <!--<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">-->

								   <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

									   <thead>

										   <tr>

												 <th>Attendance Date / Leave Added Date</th>

												 <th>Day</th>

												 <th>Department Name</th>

												 <th>Employee ID</th>

												 <th>Name</th>

												 <th>Time In</th>

												 <th>Time In Remark</th>

												 <th>Time Out</th>

												 <th>Time Out Remark</th>

												 <th>Hrs</th>
												  <th>OT1.5</th>
												 <th>OT2</th>

												 <th>Day Type</th>

												 <th>Leave</th>
												 <th>Reason</th>
												 <th>Leave From</th>
												 <th>Leave To</th>

										   </tr>

									   </thead>

									 

									   <tbody>

									   <?php 

									   include('connect.php');

							

									   if(isset($_POST['show_record']))

									   {


										$dpt=$_POST['dept'];

											 $range = $_POST['date_range'];

											 $ex = explode(' - ', $range);

										  $from = date('Y-m-d', strtotime($ex[0]));

											 $to = date('Y-m-d', strtotime($ex[1]));


										  
										   if($dpt!=='all')
										   {

											  
                                            	$getEmployees = "SELECT  A.employee_id AS empid, A.eid, A.firstname,A.lastname,B.department_name FROM  employees A inner join department B on A.department_id=B.id  WHERE A.admin_id='".$_SESSION['id']."' AND B.id= $dpt order by A.department_id";
										 

											}

										   else

										   if($_POST['dept']=='all')

										   {
										       
                                            	$getEmployees = "SELECT  A.employee_id AS empid, A.eid, A.firstname,A.lastname,B.department_name FROM  employees A inner join department B on A.department_id=B.id  WHERE A.admin_id='".$_SESSION['id']."'  order by A.department_id";
											 //  $getEmployees = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC";

										    }
										


									 

    									   $result = $conn->query($getEmployees);
    									  

    									   while($row=mysqli_fetch_array($result)){

    										   

    										   extract($row);
    										   
    										   
   extract($row);
										$id = $row['eid'];
										$employeeID=$row['empid'];
										$emp_fname = $row['firstname'];
										$emp_lname = $row['lastname'];
										   

		$row22 = $conn->query("SELECT date, num_hr,time_in,time_out,daytype,time_in_remark,time_out_remarks FROM attendance WHERE attendance.date BETWEEN '$from' AND '$to' AND employee_id='".$id."' ");
                                          while($row2=$row22->fetch_array())
    									   { 
    									        $dayname = $row2['date'];
                                                 $dateObj = DateTime::createFromFormat('Y-m-d', $dayname);
                                                 $dayOfWeek = $dateObj->format('l');
                                              
												$ot1=0;
												$ot2=0;
												
										$hrs= number_format((float)$row2['num_hr'], 2, '.', '');  
								
											if($dayOfWeek!="Sunday")
											{
											    $ot1=$hrs;
											}
											else
											{
											    $ot2=$hrs; 
											}
											
											
											
											
    									   
										$date = date('d/m/Y', strtotime($row2['date']));


									
										$timein = $row2['time_in'];
										$timeout=$row2['time_out'];


										$daytype=$row2['daytype'];



										   $hsql = "SELECT * FROM half_attendance WHERE date = '".$row['date']."' AND employee_id='".$id."' AND approve_status=1";

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

										   
										   

                              
                              
                              ?>
                               <tr>

											   <td><?php echo $date; ?></td>
												 <td><?php 
                                              
                                                 echo $dayOfWeek;
												 ?></td> 
                                                
												<td><?php echo $row['department_name']; ?></td>

											   <td><?php echo $employeeID; ?></td>

											   <td><?php echo $emp_fname." ".       $emp_lname; ?></td>

											   <td><?php echo $timein; ?></td>

											   <td><?php echo $row2['time_in_remark']; ?></td>

											   <td><?php echo $timeout; ?></td>

												<td><?php echo $row2['time_out_remarks']; ?></td>

											   <td><?php  $hrs= number_format((float)$row2['num_hr'], 2, '.', '');  
											   echo $hrs;
											   ?>
											   
											   </td>
                                                <td>
                                                    <?php echo ($dayOfWeek!="Sunday") ? $hrs : " ";
                                                    ?>
                                                    
                                                </td>
                                                <td> <?php echo ($dayOfWeek=="Sunday") ? $hrs : "";
                                                    ?>
                                                    
                                                </td>
											   <td><?php echo $daytype.'<br>'.$half; ?> </td>
											   <td>
											      
											   </td>
											   <td>
											    
											   </td>
											   <td>
											    
											   </td>
											   <td>
											    
											   </td>

											  



										  </tr>
                              <?php
    									   }
                                $hrow11 = $conn->query( "SELECT * FROM leave_application  WHERE from_date >= '".$from."' AND  to_date <= '".$to."' AND employee_id='".$row['eid']."' AND status=1");

										 
                                while($hrow1=$hrow11->fetch_array())
                                {
										
											   $leave = '<span class="label label-danger pull-right">Leave - '.$hrow1['leave_type'].'</span>';
											   $Lreason='<span class="label label-danger pull-right">'.$hrow1['reason'].'</span>';
											   $Lfrom=$hrow1['from_date'];
											    $Lto=$hrow1['to_date'];
											    $leavetype_status=$hrow1['leavetype_status'];

										 
										 
										 
									   ?>


									   

										   <tr>

											   <td><?php echo date('d/m/Y', strtotime($hrow1['added_date'])); ?></td>
												 <td><?php 
                                              
                                                 echo $dayOfWeek;
												 ?></td> 
                                                
												<td><?php echo $row['department_name']; ?></td>

											   <td><?php echo $employeeID; ?></td>

											   <td><?php echo $emp_fname." ".       $emp_lname; ?></td>

											   <td></td>

											   <td></td>

											   <td></td>

												<td></td>

											   <td>
											   <?php
											   if($leavetype_status=="0.5")
											   {
											       ?>
											       4
											       <?php
											   }
											   else{
											       ?>
											       8
											       <?php
											   }
											   ?>
											   </td>
                                                <td>
                                                  
                                                </td>
                                                <td>
                                                </td>
											   <td></td>
											   <td>
											       <?= $leave;?>
											   </td>
											   <td>
											       <?= $Lreason;?>
											   </td>
											   <td>
											       <?= $Lfrom;?> 
											   </td>
											   <td>
											       <?= $Lto;?> 
											   </td>

											  



										  </tr>

									   <?php 
    									   }
									   }
									   }
									   ?>

									   </tbody>

								   </table>

							   </div>

							  

						   </div>

					   </div>

					   

					   </div>

					   </div>

					   </div>

		   <?php include("footer.php"); ?>

		   <?php include 'scripts.php'; ?> 
