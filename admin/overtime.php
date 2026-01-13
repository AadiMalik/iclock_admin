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
                    <h3 class="text-primary">Overtime</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Overtime</li>
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
                                
								<a href="addovertime.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											    <th>Employee ID</th>
												<th>Name</th>
									            <th>Day</th>
												<th>Date</th>
												<th>Rate</th>
												<th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Employee ID</th>
												<th>Name</th>
									            <th>Day</th>
												<th>Date</th>
												<th>Rate</th>
												<th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										$sql = "SELECT *, overtime.id AS otid, overtime.rate AS rt, employees.employee_id AS empid FROM overtime LEFT JOIN employees ON employees.eid=overtime.employee_id";
										$result = mysqli_query($conn,$sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
										 $id = $row['id'];
										 $emp_id = $row['employee_id'];
										 $emp_name =$row['firstname'].' '.$row['lastname'];
										 
										 $day =  $row['day'];
										 $dt =  $row['date'];
										 $rate = $row['rt'];
										
											//print_r($row);
									    ?>
										
                                            <tr>
                                                <td><?php echo $emp_id; ?></td>
                                                
                                                <td><?php echo $emp_name;?></td>
                                                <td><?php if($day==0.5) echo "Half Day";
  												          else  echo "Full Day"; ?></td>
												<td><?php echo $dt; ?></td>
                                                <td><?php echo $rate; ?></td>
                                                
												<td>
												
												<a href="editovertime.php?id=<?=$id?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="deleteovertime.php?id=<?=$id?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
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
			
