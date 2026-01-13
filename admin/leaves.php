<?php
include('connect.php');
include("header.php");
include("sidebar.php");
if(isset($_GET['id'])!="")
  {
    $delete=$_GET['id'];
    $delete=mysqli_query($conn,"UPDATE leave_type SET delete_status=1 WHERE id='".$_GET['id']."'");
  if($delete)
  {
     echo "<script>window.location='leaves.php';</script>";
  }
  else
  {
      echo mysqli_error();
  }
  }
?>
<link rel="stylesheet" href="popup_style.css">

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Employee List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Employee List</li>
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
                               Something Goes Wrong. ID s are not inserted Properly.
                            </div>
                        <?php unset($_SESSION["reply"]); } ?> 
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='success') { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Operation Performed Successfully.
                            </div>
                        <?php unset($_SESSION["reply"]); } ?>
                        <div class="card">
                            <div class="card-body">
                              <a href="addtype.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Leave Name</th>
										                          <th>No of days</th>
                                              <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Leave Name</th>
                                              <th>No of days</th>
                                              <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
                      $sql = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0";
										
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
									    ?>
										<tr>
                        <td><?php echo $row['name']; ?></td>
												<td align="center"><?php echo $row['no_of_days']; ?></td>
												<td>
												<a href="edittype.php?id=<?=$row['id']?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                        <a href="leaves.php?id=<?=$row['id']?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
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
