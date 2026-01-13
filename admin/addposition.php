<?php
	 include("header.php");
      include("sidebar.php");
    include('connect.php');
	if(isset($_POST['save']))
	{
		$title = $_POST['title'];

		$sql = "INSERT INTO position (description, admin_id) VALUES ('$title', '".$_SESSION['id']."')";
		
		if(mysqli_query($conn,$sql))
		{
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
      
	?>	


<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Position</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Position</li>
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
                                            <label class="col-lg-4 col-form-label" for="val-username">Position Title</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-title" name="title" placeholder="Enter Position" required>
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
			
