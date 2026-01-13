<?php 
	 
	  include('connect.php');
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
                                <div class="form-validation">
                                    <form class="form-valide" method="post">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Select Department</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="dept">
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
                                                <input type="text" id="reservation" class="form-control" name="date_range" value="<?php echo $_REQUEST['date_range'] ?>" required>
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
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
											      <th>Department Name</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Reason</th>
												  <th>Status</th>
												  <th>Comment</th>
                                                  <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Apply Date</th>
                                                <th>Department Name</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>From Date</th>
												  <th>To Date</th>
												  <th>Day Type</th>
												  <th>Reason</th>
												  <th>Status</th>
												  <th>Comment</th>
                                                  <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										if(isset($_POST['show_record']))
					                    {
					                    	$range = $_POST['date_range'];
						                      $ex = explode(' - ', $range);
						                      $from = date('Y-m-d', strtotime($ex[0]));
						                      $to = date('Y-m-d', strtotime($ex[1]));

					                      if($_POST['dept']=='all')
					                      {
					                        $sql = "SELECT *,employees.department_id as department_id, employees.employee_id AS empid, leave_application.id AS attid,leave_application.status as leave_status FROM leave_application LEFT JOIN employees ON employees.eid=leave_application.employee_id WHERE leave_application.added_date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND department_status=1 ORDER BY leave_application.id DESC";
					                      }
					                      else
					                      {
					                      	$sql = "SELECT *,employees.department_id as department_id, employees.employee_id AS empid, leave_application.id AS attid,leave_application.status as leave_status FROM leave_application LEFT JOIN employees ON employees.eid=leave_application.employee_id WHERE leave_application.added_date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' AND department_status=1 ORDER BY leave_application.id DESC";
					                      }

					                    }
					                    else
					                    {
					                      $sql = "SELECT *,employees.department_id as department_id, employees.employee_id AS empid, leave_application.id AS attid,leave_application.status as leave_status FROM leave_application LEFT JOIN employees ON employees.eid=leave_application.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND department_status=1 AND DATE(added_date) = CURDATE() ORDER BY leave_application.id DESC";
					                    }
										
										
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
									    ?>
										
                                            <tr>
											    <td><?php echo $date; ?></td>
											    <td><?php echo $department_name; ?></td>
                                                <td><?php echo $emp_id; ?></td>
                                                <td><?php echo $emp_fname." ".       $emp_lname; ?></td>
                                                <td><?php echo $from_date; ?></td>
                                                <td><?php echo $to_date; ?></td>
												<td><?php echo ($leavetype_status==1)?'Full Day':'Half Day'; ?></td>
												<td><?php echo $row['reason']; ?></td>
                                                <td><?php echo $status; ?></td>
                                                <td><?php echo $row['comment']; ?></td>
												<td>
												<?php if($row['leave_status']==0){ ?>
												<!-- <a href="accept_leave.php?id=<?=$aid?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-check"></i> Approve</a>
					                            <a href="approvals.php?id=<?=$aid?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-close"></i> Decline</a> -->
					                            <a href="change_status.php?change=<?=$aid?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-exchange"></i> Change </a>
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
			<?php include 'scripts.php'; ?> 
			
