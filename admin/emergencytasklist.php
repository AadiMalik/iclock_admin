<?php
    ob_start();
       include("connect.php");
}

       ob_end_flush();
?>
   <?php 
    
      include("header.php");
      include("sidebar.php");
   ?>

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">View Emergency Task </h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Emergency Task</li>
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
                                
								<a href="add_emergency.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											    <th>Emergency ID</th>
                                                <th>Assignment Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
												<th>Employee ID</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Emergency ID</th>
                                                <th>Assignment Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Employee ID</th>
                                                <th>Action</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										
										$results = mysqli_query($conn,"SELECT * FROM  tbl_emergency WHERE status = '0'");

										while($row = mysqli_fetch_array($results))
                                        {
										 extract($row);
										 $emer_task_id =    $row['emer_task_id'];
										 $assign_name = $row['assignment_name'];
										 $start_date = $row['start_date'];
										 $end_date = $row['end_date'];
                                         $id = $row['eid'];
									    ?>
										
                                            <tr>
                                                <td><?php echo $emer_task_id; ?></td>
                                                <!-- <td><?php echo $emp_fname." ".$emp_lname; ?></td> -->
                                                <td><?php echo $assign_name; ?></td>
												<td><?php echo $start_date; ?></td>
                                                <td><?php echo $end_date; ?></td>
                                                <td><?php echo $id; ?></td>
												<td>
												<a href="assign_emergency.php?emer_task_id=<?=$emer_task_id?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-pencil"></i> Assign</a>
												<a href="edit_emergency.php?emer_task_id=<?=$emer_task_id?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete_emergency.php?emer_task_id=<?=$emer_task_id?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
												</td>
										   </tr>
                                        
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						</div>
						</div>
						</div>
                    </div>
			<?php include("footer.php"); ?>
