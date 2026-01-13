<?php
	 date_default_timezone_set('Asia/kolkata');
      include('connect.php');
	  include("header.php");
      include("sidebar.php");
   
?>
   <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Leave</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Leave</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
   <?php
	if(isset($_POST['save'])){
		
		$employee = $_POST['emp'];
		
	    $from_date = $_POST['from_date'];
	    $to_date = $_POST['to_date'];
	    $day = $_POST['day'];
    	$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);
	    if($query->num_rows < 1){
			?>
			   <div class="col-lg-6">
			  <div class="alert alert-warning alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php
          echo 'Employee not found';
           ?>
      <strong>
							  
			   </div> 
			  </div> 
			  <?php }
			else
			{
		 		$row = $query->fetch_assoc();
 				$slwp ="INSERT INTO leaves_application(admin_id,employee_id,from_date,to_date,reason) VALUES ('".$row['admin_id']."','".$row['eid']."','$from_date','$to_date','$reason')";
				$qlwp = mysqli_query($conn,$slwp);
				$period = new DatePeriod(new DateTime($from_date),new DateInterval('P1D'),new DateTime($to_date));
					    foreach ($period as $key => $value) {
				     $leave_date=$value->format('Y-m-d') ;   
				     $sql_leave ="INSERT INTO leaves_date(employee_id,leave_date) VALUES ('".$row['eid']."','$leave_date')";
						$query_leave = mysqli_query($conn,$sql_leave);   
				}
			}    
}
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
                                        
										<?php include('connect.php'); ?>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-employee">Employee</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="emp" id="val-employee" required>
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
                                            <label class="col-lg-4 col-form-label" for="val-date">From Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  name="from_date" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">To Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  name="to_date" required>
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
			
