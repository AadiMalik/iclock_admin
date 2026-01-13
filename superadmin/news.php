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
                    <h3 class="text-primary">News List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> News List</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='danger') { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Something Goes Wrong
                            </div>
                        <?php unset($_SESSION["reply"]); } ?> 
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='success') { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Operation Performed Successfully
                            </div>
                        <?php unset($_SESSION["reply"]); } ?>
                        <div class="card">
                            <div class="card-body">
                                
								<a href="addnews.php" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										$sql = "SELECT * FROM news where delete_status=0";
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
									    ?>
										
                                            <tr>
                                                <td><?php echo $row['details']; ?></td>
                                                <td>
                                                  <?php if($row['status']==0){?>
                                                    <span class="label label-success">
                                                      Active
                                                    </span>
                                                  <?php } 
                                                  else {?>
                                                    <span class="label label-warning">
                                                      Deactive
                                                    </span>
                                                <?php } ?>
                                                
                                                </td>
												<td>
												
												<a href="editnews.php?id=<?=$row['id']?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete.php?news=<?=$row['id']?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
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
			
