<?php
	ob_start();
    include('connect.php');
	if(isset($_GET['id']))
    {
        $id=$_GET['id'];
	    if(isset($_POST['update'])){
		
	    $amt= $_POST['amount'];
		
		
		$updated = mysqli_query($conn,"UPDATE incentive SET 
                 amt='$amt' WHERE id='$id'");
       if($updated)
      {
         header("Location:incentive.php");
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
                    <h3 class="text-primary">Edit Incentive </h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Incentive</li>
                    </ol>
                </div>
            </div>
			
			<?php 
  

  if(isset($_GET['id']))
  {
  $id=$_GET['id'];
 
  $getselect=mysqli_query($conn,"SELECT *FROM incentive WHERE id = '$id'");
 
  while($rows = mysqli_fetch_array($getselect))
  {
	  
	$amount = $rows['amt'];
	
	
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
                                            <label class="col-lg-4 col-form-label" for="val-username">Amount </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-amt" name="amount" value="<?php echo $amount; ?>" required>
                                            </div>
                                        </div>
										
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                            </div>
                                        </div>
                                    </form>
									
									<?php }} 
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
			
