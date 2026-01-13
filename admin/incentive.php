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
                    <h3 class="text-primary">Incentive</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Incentive</li>
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
                                
								<a href="addincentive.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											      <th>Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>Amount</th>
												  <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                  <th>Date</th>
												  <th>Employee ID</th>
												  <th>Name</th>
												  <th>Amount</th>
												  <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										$sql = "SELECT *, incentive.id AS iid, employees.employee_id AS empid FROM incentive LEFT JOIN employees ON employees.eid=incentive.employee_id ORDER BY date_incentive DESC" ;
										$result = mysqli_query($conn,$sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
										 $id = $row['id'];
										 $date=date('M d, Y', strtotime($row['date_incentive']));
										 $emp_id = $row['employee_id'];
										 $emp_name =$row['firstname'].' '.$row['lastname'];
										 $amount = number_format($row['amt'], 2);
										//print_r($row);
									    ?>
										
                                            <tr>
											    <td><?php echo $date; ?></td>
                                                <td><?php echo $emp_id; ?></td>
                                                
                                                <td><?php echo $emp_name;?></td>
                                                <td><?php echo $amount; ?></td>
                                                
                                                
												<td>
												
												<a href="editincentive.php?id=<?=$id?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="deleteincentive.php?id=<?=$id?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
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
			
