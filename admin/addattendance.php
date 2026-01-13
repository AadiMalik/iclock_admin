<?php
    include('connect.php');
	if(isset($_POST['save'])){
		$employee = $_POST['emp'];
		$date = $_POST['date'];
		$time_in = $_POST['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));
        $day = $_POST['day'];
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			echo 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$emp = $row['eid'];

			$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
			$query = $conn->query($sql);

			if($query->num_rows > 0){
				?>
				<script>window.alert("Employee attendance for the day exist");</script>
				
				<?php
				//echo 'Employee attendance for the day exist';
			}
			else{
				$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, daytype) VALUES ('$emp', '$date', '$time_in','$time_out','$day')";
				if($conn->query($sql)){
					header('location: attendance.php');
					
					$id = $conn->insert_id;

					$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$emp'";
					$query = $conn->query($sql);
					$srow = $query->fetch_assoc();

					if($srow['time_in'] > $time_in){
						$time_in = $srow['time_in'];
					}

					if($srow['time_out'] < $time_out){
						$time_out = $srow['time_out'];
					}


					$time_in = new DateTime($time_in);
					$time_out = new DateTime($time_out);
					//$interval = $time_in->diff($time_out);
					$interval = $time_in->diff($time_out);
					$hrs = $interval->format('%h');
					$mins = $interval->format('%i');
					$mins = $mins/60;
					$int = $hrs + $mins;
					
                    if($int < 6.5)
					   $status = 0.5;
					else
					   $status = 1;
					
                   $sql = "UPDATE attendance SET status = '$status', num_hr = '$int'  WHERE id = '$id'";
					
					$conn->query($sql);
                       
				}
				
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
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
                    <h3 class="text-primary">Add Attendance</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Attendance</li>
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
                                    <form class="form-valide" action="" method="post">
                                       <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-employee">Employee</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="emp" id="val-employee">
                                                    <option value="" selected>Please select</option>
                                                    <?php
													  $sql = "SELECT * FROM employees WHERE admin_id='".$_SESSION['id']."'";
													  $query = mysqli_query($conn,$sql);
													  while($row = mysqli_fetch_assoc($query)){
														echo "
														  <option value='".$row['employee_id']."'>".$row['firstname'].' '.$row['lastname']."</option>
														";
													  }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Date </label>
                                            <div class="col-lg-6 date">
                                                <input type="date" class="form-control datepicker" id="datepicker_add" name="date" placeholder="Select Date" required>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-time_in">Time In </label>
                                            <div class="col-lg-6 bootstrap-timepicker">
                                                <input type="time" class="form-control timepicker" id="time_in" name="time_in" placeholder="Select Time In" required>
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-time_out">Time Out </label>
                                            <div class="col-lg-6 bootstrap-timepicker">
                                                <input type="time" class="form-control" id="time_out" name="time_out" placeholder="Select Time Out" required>
                                            </div>
                                        </div>
                                        
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-daytype">DayType</label>
                                            <div class="col-lg-6 ">
                                                    <select name="day" class="form-control custom-select">
                                                       <option>--Select--</option>
                                                       <option value="Sunday">Sunday</option>
                                                       <option value="Holiday">Holiday</option>
                                                    </select>
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
