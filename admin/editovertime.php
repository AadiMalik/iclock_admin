<?php
	   ob_start();
       include("connect.php");
	   if(isset($_GET['id']))
       {
         $id=$_GET['id'];
		 
	    if(isset($_POST['update']))
        {
		   $empid = $_POST['emp'];
	       $day = $_POST['day'];
		   $date = $_POST['date'];
		   
		   $sql = "SELECT * FROM employees WHERE employee_id = '$empid'";
	       $query = mysqli_query($conn,$sql);
		   if(mysqli_num_rows($query) < 1){
			$_SESSION['error'] = 'Employee not found';
		   }
		   else{
			$row = mysqli_fetch_assoc($query);
			$employee_id = $row['eid'];
			$rt = $row['rate'];
			$rate = $rt * $day; 
		   
		    $sql = "UPDATE overtime SET day = '$day', date = '$date', rate = '$rate' WHERE id = '$id'";
			if(mysqli_query($conn,$sql)){
				
				header('location: overtime.php');

			  }
		 
            else
		    mysql_error();
	       
		    mysqli_close($conn);
		  }
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
                    <h3 class="text-primary">Edit Overtime</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Overtime</li>
                    </ol>
                </div>
            </div>
			
			<?php 
	

				if(isset($_GET['id'])){
				$id = $_GET['id'];
				$sql = "SELECT *, overtime.id AS otid FROM overtime LEFT JOIN employees on employees.eid=overtime.employee_id WHERE overtime.id='$id'";
				$query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
			           $day = $row['day'];
		               $dt = $row['date'];
					   $emp = $row['employee_id'];
			
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
                                        
								<input type="hidden" name="emp" value="<?php echo $emp; ?>">
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  name="date" value="<?php echo $dt; ?>">
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-daytype">DayType</label>
                                            <div class="col-lg-6 ">
                                                    <select name="day" class="form-control custom-select">
                                                       <option value="<?php echo $day; ?>"><?php if($day=='0.5') echo "HalfDay";else echo "FullDay"; ?></option>
                                                       <option value="0.5">HalfDay</option>
                                                       <option value="1">FullDay</option>
                                                    </select>
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
			
