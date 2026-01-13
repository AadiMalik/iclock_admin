<?php
    include('connect.php');
	if(isset($_GET['id']))
    {
      $id=$_GET['id'];
	
	 if(isset($_POST['update'])){
		
	    $amt= $_POST['amount'];
		
		
		$sql = "UPDATE cashadvance SET amount = '$amt' WHERE id = '$id'";
			if(mysqli_query($conn,$sql)){
				
				header('location: cashadvance.php');

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
                    <h3 class="text-primary">Edit Cash Advance </h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Cash Advance</li>
                    </ol>
                </div>
				<div></div>
            </div>
			
			<?php 
	

				if(isset($_GET['id'])){
				$id = $_GET['id'];
				
				$sql = "SELECT *, cashadvance.id AS caid FROM cashadvance LEFT JOIN employees on employees.eid=cashadvance.employee_id WHERE cashadvance.id='$id' ";
				$query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
					   $emp_id = $row['employee_id'];
			           $date = $row['date_advance'];
		               $emp_name =$row['firstname'].' '.$row['lastname'];
					   $amount = $row['amount'];
			
            ?>
			
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
			  <div class="row justify-content-center">
			       <div class="col-lg-6">
				   <?php echo "<b>" .$date.  " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .$emp_name."</b>" ;?>
				      <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
                                        
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Amount </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-amt" name="amount" value="<?php echo $amount;?>" required>
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
			
