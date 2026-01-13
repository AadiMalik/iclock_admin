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
                    <h3 class="text-primary">Employees Schedules</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Employees Schedules</li>
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
                                
								<!-- <a href="schedule_employee_print.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print"></i> Print</a> -->
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											    <th>Employee ID</th>
												<th>Name</th>
												<th>Schedule</th>
												<th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Employee ID</th>
												<th>Name</th>
												<th>Schedule</th>
												<th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										$sql = "SELECT *, employees.eid AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.admin_id='".$_SESSION['id']."'";
										$result = mysqli_query($conn,$sql);
										while($row=mysqli_fetch_assoc($result)){
											
											extract($row);
										 $id = $row['eid'];
										 $empid = $row['employee_id'];
										 $empname = $row['firstname'].' '.$row['lastname'];
										 $schedule = date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out']));
										 
											//print_r($row);
									    ?>
										
                                            <tr>
                                                
                                                <td><?php echo $empid;?></td>
                                                <td><?php echo $empname; ?></td>
                                                <td><?php echo $schedule; ?></td>
												<td>
												
												<a href="editemployee_schedule.php?id=<?=$id?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <!--<a href="deleteposition.php?id=<?//=$id?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>-->
												
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
			
