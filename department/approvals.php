<?php 
	  include('../connect.php');
	  include("header.php");
      include("sidebar.php");
      
if(isset($_GET['id']))
      {
      	$s1 = "UPDATE leave_application SET department_status=1 WHERE id = '".$_GET['id']."'";
		mysqli_query($conn,$s1);
		?>
<script>
	alert('Approval Accepted');
    window.location="approvals.php";
</script>
<?php 
      }
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
                            <a href="addleave.php" class="btn btn-primary">+ Add Leave</a>							
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Status</th>
												  <th>Admin Status</th>
												  <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Apply Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Status</th>
												  <th>Admin Status</th>
												  <th>Comment</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 									
										
										$sql = "SELECT *, employees.employee_id AS empid, leave_application.id AS attid,leave_application.status as leave_status FROM leave_application LEFT JOIN employees ON employees.eid=leave_application.employee_id WHERE employees.admin_id='".$_SESSION['admin_id']."' AND employees.department_id='".$_SESSION['id']."' ORDER BY leave_application.id DESC";
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
												$status ='<span class="label label-primary pull-right">Pending</span>';
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
                                                <td><?php echo $emp_id; ?></td>
                                                <td><?php echo $emp_fname." ".       $emp_lname; ?></td>
                                                <td><?php echo $from_date; ?></td>
                                                <td><?php echo $to_date; ?></td>
												<td><?php echo ($leavetype_status==1)?'Full Day':'Half Day'; ?></td>
												<td>
													<?php if($row['department_status']==0 && $row['leave_status']==0){ ?>
													<a href="approvals.php?id=<?=$aid?>" class="btn btn-xs btn-primary" onclick="return confirm('Are you sure to approve this Record?');"><i class="fa fa-check"></i> Approve?</a>
													<?php }else{ ?>
														<span class="label label-primary pull-right">Approved</span>
													<?php } ?>
												</td>
                                                <td><?php echo $status; ?></td>
                                                <td><?php echo $row['comment']; ?></td>
                                           

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
			
