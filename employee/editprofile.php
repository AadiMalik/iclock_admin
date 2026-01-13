<?php 
    
      include("header.php");
      include("sidebar.php");
?>
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
    $my_file=$_POST['old_slider'];

   function createSalt()
   {
    return '2123293dsj2hu2nikhiljdsd';
   }
  if($_POST['pass']!='')
  {
    $passw1 = $_POST['pass'];
    $passw = hash('sha256', $passw1);
    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);
  }
  else
  {
    $pass=$_POST['my_password'];
  }
  
          $imgFile = $_FILES['photo']['name'];
		  $tmp_dir = $_FILES['photo']['tmp_name'];
		  $imgSize = $_FILES['photo']['size'];
	      if($imgFile)
		  {
			$upload_dir = '../admin/uploaded/employee/';
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
			$productimage=$_POST['old_slider'];
		}
		  
		   
		   $updated=mysqli_query($conn,"UPDATE employees SET 
                employee_id='$email',password='$pass',firstname='$fname',lastname='$lname',address='$address',birthdate='$date',contact_info='$phone',gender='$gender',image='$productimage' WHERE eid='".$_SESSION["id"]."'") or die();
         $_SESSION["fname"] = $fname;
         $_SESSION["lname"] = $lname;
         $_SESSION["image"] = $productimage;
       echo "<script>window.location='editprofile.php';</script>";
	       
      }
	   
	   ob_end_flush();
?>
	
<?php


$sql2 = "SELECT * FROM employees WHERE eid='".$_SESSION["id"]."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {

    while($rows = mysqli_fetch_assoc($result2)) {
	
	$uname = $rows['employee_id'];
	$password1 = $rows['password'];
	$firstnm = $rows['firstname'];
	$lastnm = $rows['lastname'];
	$file = $rows['image'];
    $address = $rows['address'];
    $birthdate = $rows['birthdate'];
    $contact_info = $rows['contact_info'];
    $gender = $rows['gender'];
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
                                        <input type="hidden" name="my_password" value="<?php echo $password1; ?>">
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Username </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="unm" value="<?php echo $uname; ?>" readonly>
                                            </div>
                                        </div>
									
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Password </label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="val-pass" name="pass" pattern="[0-9]{4}" maxlength="4" value="" >
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
                                            <label class="col-lg-4 col-form-label" for="val-address">Address </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="address"><?php echo $address; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Birth Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  value="<?php echo $birthdate; ?>" name="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-contact">Contact Info</label>
                                            <div class="col-lg-6">
                                                <input type="text" pattern="[0-9]{10}" maxlength="10" minlength="10" class="form-control" id="val-contact" name="phone"  value="<?php echo $contact_info; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Gender </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-gender" name="gender">
                                                    <option value="Male" <?php if($gender=='Male'){ echo "selected"; } ?>>Male</option>
                                                    <option value="Female" <?php if($gender=='Female'){ echo "selected"; } ?>>Female</option>
                                                </select>
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
