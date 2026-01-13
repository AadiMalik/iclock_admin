<?php
	   ob_start();
       include("connect.php");
	   if(isset($_GET['id']))
       {
         $id=$_GET['id'];
		 
	    if(isset($_POST['update']))
        {
		   
	       $sched_id = $_POST['schedule'];
		
		$sql = "UPDATE employees SET schedule_id = '$sched_id' WHERE eid = '$id'";
		if(mysqli_query($conn,$sql)){
				
				header('location: schedule_employee.php');

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
                    <h3 class="text-primary">Edit Employee Schedule</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employee Schedule</li>
                    </ol>
                </div>
            </div>
			
			<?php 
	

				if(isset($_GET['id'])){
				$id = $_GET['id'];
				$sql = "SELECT *, employees.eid AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$id'";
				$query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
					   $sid=$row['id'];
			           $schedule = date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out']));
		               
			
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
                                    <form class="form-valide" action="" method="post">
                                        
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Schedule</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-schedule" name="schedule">
                                                    <option value="<?php echo $schedule; ?>" ><?php echo $schedule; ?></option>
                                                    <?php
													  $sql = "SELECT * FROM schedules";
													  $query = mysqli_query($conn,$sql);
													  while($srow = mysqli_fetch_assoc($query)){
														echo "
														  <option value='".$srow['id']."'>".date('h:i A', strtotime($srow['time_in'])).' - '.date('h:i A', strtotime($srow['time_out']))."</option>
														";
													  }
													?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update"><i class="fa fa-check-square-o">Update</i></button>
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
			
