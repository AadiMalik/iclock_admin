<?php
	include("checkadmin.php");
    include('../connect.php');
	ob_start();
	
	if(isset($_POST["update"]))
   {
	extract($_POST);
	
	$email = $_POST['unm'];
	$fname = $_POST['fnm'];
	$lname = $_POST['lnm'];
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
			$upload_dir = 'uploaded/';
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
			$productimage = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$my_file);
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
			$productimage=$_POST['old_slider'];
		}
		  
		   
		   $updated=mysqli_query($conn,"UPDATE superadmin SET 
                username='$email',password='$pass',firstname='$fname',lastname='$lname',image='$productimage' WHERE id='".$_GET['id']."'") or die();
       
	       
      }
	   
	   ob_end_flush();
?>
	
<?php


$sql2 = "SELECT * FROM superadmin WHERE id='".$_GET['id']."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {

    while($rows = mysqli_fetch_assoc($result2)) {
	
	$uname = $rows['username'];
	$password = $rows['password'];
	$firstnm = $rows['firstname'];
	$lastnm = $rows['lastname'];
	$file = $rows['image'];
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
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Photo</label>
                                            <div class="col-lg-6">
                                               <input type="file" class="form-control" id="val-file" name="photo" <?php if(!isset($file)){ echo "required"; } ?> placeholder="Choose a file"> 
											   
												<input type="hidden" name="old_slider" value="<?php if(isset($file)){ echo $file; } ?>">
																   
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
