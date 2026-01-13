<?php 
include('../connect.php');
include("header.php");
include("sidebar.php");
if(isset($_REQUEST['skey'])){
    $sql=" UPDATE department SET status= '".$_REQUEST['act']."' WHERE id =".$_REQUEST['skey'];
   mysqli_query($conn,$sql);
}
?>

<style>
    .active-btn{
            background: #3ab706;
    color: white;
    padding: 4px;
    border-radius: 9px;
    }
      .inactive-btn{
            background: #ef5350;
    color: white;
    padding: 4px;
    border-radius: 9px;
    }
</style>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Department / Location List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Department / Location List</li>
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
                                
								<a href="adddepartment.php" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Department Name</th>
												<th>Login</th>
                                                <th>Member Since</th>
                                                 <th>Status</th>
                                                <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Department Name</th>
												<th>Login</th>
                                                <th>Member Since</th>
                                                 <th>Status</th>
                                                <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										$sql = "SELECT * FROM department where delete_status=0 AND admin_id='".$_SESSION['id']."'";
										$result = $conn->query($sql);
										if (!$result) {
    die("Query failed: " . $conn->error);
}
										while($row=mysqli_fetch_array($result)){
										$date = date('M d, Y', strtotime($row['created_on']));
										$expiry_date = date('M d, Y', strtotime($row['expiry_date']));
									    ?>
										
                                            <tr>
                                                <td><?php echo $row['department_name']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php if($row['status']==2){ ?>
                                                    <a class="inactive-btn" href="department.php?act=0&skey=<?=$row['id']?>">Inactive</a>
                                                <?php }else{?>
                                                   <a class="active-btn" href="department.php?act=2&skey=<?=$row['id']?>">Active</a> 
                                              <?php  }?></td>
												<td>
												<a href="emailsend.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-send"></i> Send</a>
												<a href="editdepartment.php?id=<?=$row['id']?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete.php?department=<?=$row['id']?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
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
			
