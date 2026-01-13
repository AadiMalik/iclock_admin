<?php
    include('connect.php');
	if(isset($_POST['save'])){
		
	    $date = $_POST['date'];
		
			$sql = "INSERT INTO holiday (date) VALUES ('$date')";
			if(mysqli_query($conn,$sql)){
				header('location: holiday.php');

			}
           else
		   mysql_error();
	       
		   mysqli_close($conn);
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
                    <h3 class="text-primary">Add Holiday</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Holiday</li>
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
                                            <label class="col-lg-4 col-form-label" for="val-date">Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date">
                                            </div>
                                        </div>
										
                                      <!--  <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-contact">Month</label>
                                            
                                                    <select name="month" class="form-control custom-select">
                                                        <option>--Select Month--</option>
                                                        <option value="Jan">Jan</option>
                                                        <option value="Feb">Feb</option>
                                                        <option value="March">March</option>
														<option value="Apr">Apr</option>
														<option value="May">May</option>
														<option value="June">June</option>
														<option value="July">July</option>
														<option value="Aug">Aug</option>
														<option value="Sept">Sept</option>
														<option value="Oct">Oct</option>
														<option value="Nov">Nov</option>
														<option value="Dec">Dec</option>
														
                                                    </select>
                                               
                                        </div>
                                        -->
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
			
