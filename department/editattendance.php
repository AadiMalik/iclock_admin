<?php include('../connect.php');
	if(isset($_GET['id']))
       {
         $id=$_GET['id'];
		 
	    if(isset($_POST['update']))
        {
         $id=$_GET['id'];
		
		$date = $_POST['date'];
		$time_in = $_POST['time_in'];
		$time_in1 = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out1 = date('H:i:s', strtotime($time_out));

		/*$sql = "UPDATE attendance SET date = '$date', time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
		if($conn->query($sql)){*/
			
			 //header('location: attendance.php');
			//$_SESSION['success'] = 'Attendance updated successfully';

			$sql = "SELECT * FROM attendance WHERE id = '$id'";
			$query = $conn->query($sql);
			$row = $query->fetch_assoc();
			$emp = $row['employee_id'];

			$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$emp'";
			$query = $conn->query($sql);
			$srow = $query->fetch_assoc();

			//if($srow['time_in'] > $time_in){
				$db_time_in = $srow['time_in'];
			//}

			//if($srow['time_out'] < $time_out){
				$db_time_out = $srow['time_out'];
			//}

			$time_in = new DateTime($time_in);
			$time_out = new DateTime($time_out);
			$interval = $time_in->diff($time_out);
			$hrs = $interval->format('%h');
			$mins = $interval->format('%i');
			$mins = $mins/60;
			$int = $hrs + $mins;

			$db_time_in = new DateTime($db_time_in);
			$db_time_out = new DateTime($db_time_out);
			$db_interval = $db_time_in->diff($db_time_out);
			$db_hrs = $db_interval->format('%h');
			$db_mins = $db_interval->format('%i');
			$db_mins = $db_mins/60;
			$db_int = $db_hrs + $db_mins;
	                        if($int < $db_int)
							   $status = 0.5;
							else
							   $status = 1;

			$sql = "UPDATE attendance SET status = '$status', time_in = '$time_in1', time_out = '$time_out1', num_hr = '$int'  WHERE id = '$id'";
			$conn->query($sql);
			$_SESSION['success'] = 'Attendance updated successfully';
			header('location: attendance.php');
			/*}
		else{
			$_SESSION['error'] = $conn->error;
		   }*/
	   }
	
		}
	 
			  
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
                    <h3 class="text-primary">Edit Attendance</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Attendance</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

			<?php 
	

				if(isset($_GET['id'])){
				$id = $_GET['id'];
				$sql = "SELECT *, attendance.id as attid FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.id = '$id'";
		        $query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
			           $dt = $row['date'];
		               $ti = $row['time_in'];
			           $to = $row['time_out'];
            ?>
			
			
			
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
                                            <label class="col-lg-4 col-form-label" for="val-date">Date </label>
                                            <div class="col-lg-6 date">
                                                <input type="date" class="form-control timepicker" id="datepicker_add" name="date" value="<?php echo $dt; ?>" readonly required>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-time_in">Time In </label>
                                            <div class="col-lg-6 bootstrap-timepicker">
                                                <input type="time" class="form-control timepicker" id="time_in" name="time_in" value="<?php echo $ti; ?>" required>
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-time_out">Time Out </label>
                                            <div class="col-lg-6 bootstrap-timepicker">
                                                <input type="time" class="form-control" id="time_out" name="time_out" value="<?php echo $to; ?>" required>
                                            </div>
                                        </div>
                                        
                                        
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
			
