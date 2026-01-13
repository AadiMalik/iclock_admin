<?php
include("header.php");
include("sidebar.php");
include('../connect.php');
	
	if(isset($_POST["btn_save"]))
   {
	extract($_POST);
        $sql2 = "SELECT * FROM admin WHERE id='".$_SESSION['id']."' ";
        $result2 = mysqli_query($conn,$sql2);
        $rows = mysqli_fetch_assoc($result2);
		  
		$sql="INSERT INTO `news`(`details`, `added_date`, `status`) VALUES ('".$details."','".date('Y-m-d')."','".$_POST['status']."')"; 
        if(mysqli_query($conn,$sql))
          {
            $_SESSION['reply']='success';
            echo '<script>window.location="news.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="addnews.php"</script>';
          }  
	       
      }
?>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Department</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Department</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='danger') { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Something Goes Wrong
                            </div>
                        <?php unset($_SESSION["reply"]); } ?> 
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Details </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-details" name="details" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Status </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="status">
                                                    <option value="0"> On </option>
                                                    <option value="1"> Off </option>
                                                </select>
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
			<?php include("footer.php"); ?>