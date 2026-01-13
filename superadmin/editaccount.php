<?php
	include('../connect.php');
	ob_start();
	
	if(isset($_POST["update"]))
   {
	extract($_POST);
	
	$email = $_POST['unm'];
	$fname = $_POST['fnm'];
	$lname = $_POST['lnm'];
    $company = $_POST['company'];
    $expiry_date=date('Y-m-d',strtotime($_POST['expiry_date']));
	$passw1 = $_POST['pass'];
	      
    $passw = hash('sha256', $passw1);

   function createSalt()
   {
    return '2123293dsj2hu2nikhiljdsd';
   }
  $salt = createSalt();
  $pass = hash('sha256', $salt . $passw);
  
          $imgFile = $_FILES['photo']['name'];
		  $tmp_dir = $_FILES['photo']['tmp_name'];
		  $imgSize = $_FILES['photo']['size'];
	      if($imgFile)
		  {
			$upload_dir = '../admin/uploaded/';
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
			$productimage = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					@unlink($upload_dir.$my_file);
					move_uploaded_file($tmp_dir,$upload_dir.$productimage);
				}
				else
				{
					$errMSG = "Sorry, Your File Is Too Large To Upload. It Should Be Less Than 5MB.";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF Extension Files Are Allowed.";		
			}	
		}
		else
		{
			$productimage=$_POST['my_file'];
		}
		  
		$sql="UPDATE admin SET 
                username='$email',password='$pass',firstname='$fname',lastname='$lname',image='$productimage',status='$status',company='$company',expiry_date='$expiry_date' WHERE id='".$_GET['id']."'";   
		if(mysqli_query($conn,$sql))
          {
              $sql1="UPDATE department SET expiry_date='$expiry_date' WHERE admin_id='".$_GET['id']."'";   
		        mysqli_query($conn,$sql1);
		        
		        $sql1="UPDATE employees SET expiry_date='$expiry_date' WHERE admin_id='".$_GET['id']."'";   
		        mysqli_query($conn,$sql1);
            
            $_SESSION['reply']='success';
            echo '<script>window.location="account.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="editaccount.php?id='.$_GET['id'].'"</script>';
          }  
       
	       
      }
	   
	   ob_end_flush();
?>
	
<?php


$sql2 = "SELECT * FROM admin WHERE id='".$_GET['id']."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {

    while($rows = mysqli_fetch_assoc($result2)) {
	
	$uname = $rows['username'];
	$password = $rows['password'];
	$firstnm = $rows['firstname'];
	$lastnm = $rows['lastname'];
    $company = $rows['company'];
	$file = $rows['image'];
    $expiry_date = $rows['expiry_date'];
    $status = $rows['status'];
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
                    <h3 class="text-primary">Edit Profile</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
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
                                            <label class="col-lg-4 col-form-label" for="val-username">Username(Email) </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="unm" value="<?php echo $uname; ?>" required>
                                            </div>
                                        </div>
									
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Password </label>
                                            <div class="col-lg-6">
                                                <input type="Password" class="form-control" id="val-pass" name="pass" value=""  required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Company </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="company" name="company" value="<?php echo $company; ?>"  required>
                                            </div>
                                        </div>
									
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Firstname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="fnm" value="<?php echo $firstnm; ?>"  required>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Lastname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-lastname" name="lnm" value="<?php echo $lastnm; ?>"  required>
                                            </div>
                                        </div>
										<!--
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Photo</label>
                                            <div class="col-lg-6">
                                               <input type="file" class="form-control" id="val-file" name="photo" <?php if(!isset($file)){ echo "required"; } ?> placeholder="Choose a file"> 
											   
												<input type="hidden" name="my_file" value="<?php if(isset($file)){ echo $file; } ?>">
                                                <img src="<?php echo (!empty($file))? '../admin/uploaded/'.$file:'../admin/uploaded/profile.jpg'; ?>" width="50%" height="50%">
																   
                                            </div>
                                        </div>-->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Expiry Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  name="expiry_date" value="<?php echo $expiry_date; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Status</label>
                                            <div class="col-lg-6">
                                                <select name="status" class="form-control">
                                                    <option value="0" <?php if($status==0){ echo "selected"; }?>>Enable</option>
                                                    <option value="1" <?php if($status==1){ echo "selected"; }?>>Disable</option>
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