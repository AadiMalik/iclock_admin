<?php
    include("header.php");
    include("sidebar.php");	
    include('connect.php');
	if(isset($_POST['save'])){
		$name = $_POST['name'];
	    $no_of_days = $_POST['no_of_days'];			
			$sql = "UPDATE leave_type SET name='$name',no_of_days='$no_of_days' WHERE id='".$_GET['id']."'";
			if(mysqli_query($conn,$sql))
            {
				//header('location: leaves.php');
                echo "<script>window.location='leaves.php';</script>";
            }
       }
       $result = mysqli_query($conn,"SELECT * FROM leave_type WHERE id='".$_GET['id']."'");
        //print_r($result);
        $row= mysqli_fetch_array($result);
	?>	
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Leave Type</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Leave Type</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="name" value="<?php echo $row['name']; ?>" required>
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">No Of Days </label>
                                            <div class="col-lg-6">
                                                <input type="number" min="0" class="form-control" value="<?php echo $row['no_of_days']; ?>"  name="no_of_days" required>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="save">Submit</button>
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
			
