<?php
    include('connect.php');
	if(isset($_POST['save'])){
		$empid = $_POST['emp'];
	    $amt= $_POST['amount'];
		$dt= $_POST['date'];
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$empid '";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['eid'];
			$sql = "INSERT INTO incentive (employee_id, date_incentive, amt) VALUES ('$employee_id', '$dt', '$amt')";
			if(mysqli_query($conn,$sql)){
				header('location: incentive.php');

			}
           else
		   mysql_error();
	       
		   mysqli_close($conn);
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
                    <h3 class="text-primary">Add Incentive </h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Incentive</li>
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
                                        <?php include('connect.php'); ?>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-employee">Employee</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="emp" id="val-employee">
                                                    <option value="" selected>Please select</option>
                                                    <?php
													  $sql = "SELECT * FROM employees";
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
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  name="date">
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Amount </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-amt" name="amount" placeholder="Enter Cash Incentive" required>
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
			
