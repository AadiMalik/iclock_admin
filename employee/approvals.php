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
                    <h3 class="text-primary">Approvals</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Approvals</li>
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
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Apply Date</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Status</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 									
										
										$sql = "SELECT *, employees.employee_id AS empid, leave_application.id AS attid,leave_application.status as leave_status FROM leave_application LEFT JOIN employees ON employees.eid=leave_application.employee_id WHERE employees.eid='".$_SESSION['id']."' ORDER BY leave_application.added_date DESC";
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
											if($row['leave_status']==2)
											{
												$status ='<span class="label label-danger pull-right">Decline</span>';
											}
											else if($row['leave_status']==1)
											{
												$status ='<span class="label label-success pull-right">Approve</span>';
											}
											else
											{
												$status ='<span class="label label-warning pull-right">Pending</span>';
											}
											
											
										 $id = $row['eid'];
										 $aid= $row['attid'];
										 $date=date('M d, Y', strtotime($row['added_date']));
										 $emp_id = $row['employee_id'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
										 $from_date = date('d F Y', strtotime($row['from_date']));
										 $to_date=date('d F Y', strtotime($row['to_date']));
										 $leavetype_status=$row['leavetype_status'];
										
											//print_r($row);
									    ?>
										
                                            <tr>
											    <td><?php echo $date; ?></td>
                                                <td><?php echo $from_date; ?></td>
                                                <td><?php echo $to_date; ?></td>
												<td><?php echo ($leavetype_status==1)?'Full Day':'Half Day'; ?></td>
                                                <td><?php echo $status; ?></td>
                                           

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
			
