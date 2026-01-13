<?php
	   ob_start();
       include("connect.php");
	   if(isset($_GET['id']))
       {
         $id=$_GET['id'];
		 
	    if(isset($_POST['update']))
        {
		   
			$title = $_POST['title'];
			$rate = $_POST['rate'];

			$sql = "UPDATE position SET description = '$title' WHERE id = '$id'";
			if(mysqli_query($conn,$sql)){
				
			    //header('location: position.php');
			   ?>
            <script>
                window.location="position.php";
            </script>
<?php

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
                    <h3 class="text-primary">Edit Position</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Position</li>
                    </ol>
                </div>
            </div>
			
			<?php 
	

				if(isset($_GET['id'])){
				$id = $_GET['id'];
				$sql = "SELECT * FROM position WHERE id = '$id'";
				$query = mysqli_query($conn,$sql);
			
                while($row = mysqli_fetch_assoc($query))
				{
			           $pos = $row['description'];
		               $rt = $row['rate'];
			
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
                                            <label class="col-lg-4 col-form-label" for="val-username">Position Title</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-title" name="title" value="<?php echo $pos; ?>" required>
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
