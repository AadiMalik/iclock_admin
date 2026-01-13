<?php
	   ob_start();
       include("connect.php");
	   if(isset($_GET['id']))
       {
         $id=$_GET['id'];
		 
	    if(isset($_POST['update']))
        {
		   
				$time_in = $_POST['time_in'];
				$time_in = date('H:i:s', strtotime($time_in));
				$time_out = $_POST['time_out'];
				$time_out = date('H:i:s', strtotime($time_out));

				$sql = "UPDATE schedules SET time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
				
				if(mysqli_query($conn,$sql)){
						
				header('location: schedule.php');

				}
			   else
			   mysql_error();
			   
			   mysqli_close($conn);
		}
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
                    <h3 class="text-primary">Edit Schedule</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Schedule</li>
                    </ol>
                </div>
            </div>
			
			<?php 
		        if(isset($_GET['id'])){
				$id = $_GET['id'];
				$sql = "SELECT * FROM schedules WHERE id = '$id'";
				$query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
			           $tin = $row['time_in'];
		               $tout = $row['time_out'];
            ?>
			
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
                                                <input type="text" class="form-control" id="time_in" name="time_in" value="<?php echo $tin; ?>" required>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="time_out">Time Out</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="time_out" name="time_out" value="<?php echo $tout; ?>" required>
                                            </div>
                                        </div>
										
                                        <!--<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Birth Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date">
                                            </div>
                                        </div>
										-->
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                            </div>
                                        </div>
                                    </form>
									
									<?php 
									}
									} 
										mysqli_close($conn);
									?>
									
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
			<?php include("footer.php"); ?>
			
