
<?php 
	 
	  include('../connect.php');
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
                <form action='' method='post'>
                    <label>From:
                    <input required type='date' name='from'>
                    </label>
                    <label>To:
                    <input required type='date' name='to'>
                    </label>
                    <label>
                    <input required type='submit' name='submit'>
                    </label>
                </form>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
												  <th>Time In</th>
												  <th>Time Out</th>
												  <th>Day Type</th>
												  <th width="15%">Status</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
												  <th>Time In</th>
												  <th>Time Out</th>
												  <th>Day Type</th>
												  <th>Status</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										
										if(isset($_POST['submit']))
										{
										    $from=$_POST['from'];
										    $to=$_POST['to'];
										    
										}
										else{
										    $from='1990-01-30';
										    $to='3000-12-30';
										}
									$sql = $conn->query("SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status 
									FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.eid='".$_SESSION['id']."' 
									AND 
								(	attendance.date between '$from' AND '$to' )  ORDER BY attendance.date DESC, attendance.time_in DESC");
										
								// 		$result = $conn->query($sql); 
										while($row=$sql->fetch_array())
										{
											
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
								// 		 $date=date('M d, Y', strtotime($row['date']));
										 $emp_id = $row['employee_id'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
										 $timein = date('h:i A', strtotime($row['time_in']));
										 $timeout=date('h:i A', strtotime($row['time_out']));
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
											    <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $timein; ?></td>
                                                <td><?php echo $timeout; ?></td>
												<td><?php echo $daytype; ?></td>
                                                <td><?php echo $status.'<br>'.$half; ?></td>
                                           

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
			
