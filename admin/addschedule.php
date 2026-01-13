<?php
	include("header.php");
    include("sidebar.php");
    include('connect.php');
	if(isset($_POST['save'])){
		$time_in = $_POST['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "INSERT INTO schedules (admin_id,time_in, time_out) VALUES ('".$_SESSION["id"]."','".$time_in."', '".$time_out."')";
		if(mysqli_query($conn,$sql)){
            ?>
            <script type="text/javascript">
                window.location.href = "schedule.php";
            </script>
            <?php

			}
           else
		   mysql_error();
	       
		   mysqli_close($conn);
		}
       
	?>	

<?php 
	
	  
?>


<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Schedule</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Schedule</li>
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
                                            <label class="col-lg-4 col-form-label" for="time_in">Time In</label>
                                            <div class="col-lg-6">
                                                <input type="time" class="form-control" id="time_in" name="time_in" placeholder="Enter In Time" required>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="time_out">Time Out</label>
                                            <div class="col-lg-6">
                                                <input type="time" class="form-control" id="time_out" name="time_out" placeholder="Enter Out Time " required>
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
			
