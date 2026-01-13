<?php include('../connect.php');
	  include("header.php");
      include("sidebar.php");
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
                                    <form class="form-valide" method="post">
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
                            	<a href="adddaily.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> Daily Attendance</a>
                            	<a href="addattendance.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>Time In</th>
												  <th>Time Out</th>
												  <th>Day Type</th>
												  <th width="15%">Status</th>
                                                  <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>Time In</th>
												  <th>Time Out</th>
												  <th>Day Type</th>
												  <th>Status</th>
                                                  <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										
										
									if(isset($_GET['show_date']))
										{
											$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['admin_id']."' AND employees.department_id='".$_SESSION['id']."' AND attendance.date='".$_GET['show_date']."' ORDER BY attendance.date DESC, attendance.time_in DESC";
										}
										else if(isset($_POST['show_record']))
											{
												$range = $_POST['date_range'];
						                      $ex = explode(' - ', $range);
						                      $from = date('Y-m-d', strtotime($ex[0]));
						                      $to = date('Y-m-d', strtotime($ex[1]));

											$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['admin_id']."' AND employees.department_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";
											}
										else
										{
											$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['admin_id']."' AND employees.department_id='".$_SESSION['id']."' AND attendance.date<='".date('Y-m-d')."' ORDER BY attendance.date DESC, attendance.time_in DESC";
										}
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
											if($row['daytype']=='LWP')
											{
												$status = ($row['attend_status']==1)?'<span class="label label-danger pull-right">Full Day Leave</span>':'<span class="label label-danger pull-right">Half Day Leave</span>';
											}
											else
											{
												$status = ($row['attend_status']==1)?'<span class="label label-primary pull-right">Full Day</span>':'<span class="label label-danger pull-right">Half Day</span>';
											}
											
											
										 $id = $row['eid'];
										 $aid= $row['attid'];
										 $date=date('M d, Y', strtotime($row['date']));
										 $emp_id = $row['employee_id'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
										 $timein =$row['time_in'];
										 $timeout=$row['time_out'];
										 $daytype=$row['daytype'];
										
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
									    ?>
										
                                            <tr>
											    <td><?php echo $date; ?></td>
                                                <td><?php echo $emp_id; ?></td>
                                                <td><?php echo $emp_fname." ".$emp_lname; ?></td>
                                                <td><?php echo $timein; ?></td>
                                                <td><?php echo $timeout; ?></td>
												<td><?php echo $daytype; ?></td>
                                                <td><?php echo $status.'<br>'.$half; ?></td>
												<td>
												<?php if($daytype!='LWP' && $daytype!='Leave' && $daytype!='Sick Leave'){ ?>
												<a href="editattendance.php?id=<?=$aid?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
					                            <a href="deleteattendance.php?id=<?=$aid?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
					                        <?php } ?>
												
												</td>
                                           

										   </tr>
                                        <?php } ?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						</div>
						</div>
						</div>
			<?php include("footer.php"); ?>
			
