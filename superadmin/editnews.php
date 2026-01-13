<?php
	include('../connect.php');
	if(isset($_POST["update"]))
   {
	extract($_POST);
		  
		$sql="UPDATE news SET status='$status',details='$details' WHERE id='".$_GET['id']."'";   
		if(mysqli_query($conn,$sql))
          {
            
            $_SESSION['reply']='success';
            echo '<script>window.location="news.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="editnews.php?id='.$_GET['id'].'"</script>';
          }  
       
	       
      }
?>
	
<?php


$sql2 = "SELECT * FROM news WHERE id='".$_GET['id']."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {

    while($rows = mysqli_fetch_assoc($result2)) {
	$status = $rows['status'];
    $details = $rows['details'];
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
                    <h3 class="text-primary">Edit Department</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Department</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='danger') { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Something Goes Wrong <?php if(isset($errMSG)) { echo $errMSG; } ?>
                            </div>
                        <?php unset($_SESSION["reply"]); } ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Details</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-details" name="details" value="<?php echo $details; ?>"  required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Status </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="status">
                                                    <option value="0" <?php if($status==0){ echo "selected"; } ?>> On </option>
                                                    <option value="1" <?php if($status==1){ echo "selected"; } ?>> Off </option>
                                                </select>
                                            </div>
                                        </div>
                                        
										
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update">Update</button>
                                            </div>
                                        </div>
                                    </form>
									<?php
									 }
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
