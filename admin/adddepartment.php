<?php
include("header.php");
include("sidebar.php");
include('../connect.php');
	
	if(isset($_POST["btn_save"]))
   {
	extract($_POST);
	
	$unm = $_POST['unm'];
    $email = $_POST['email'];
	$fname = $_POST['fnm'];
	$lname = $_POST['lnm'];
    $department_name = $_POST['department_name'];
	$passw1 = $_POST['pass'];
    $valid_pass = $_POST['pass'];
	      
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
	      /*if($imgFile)
		  {
			$upload_dir = '../department/uploaded/';
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
		{*/
			$productimage='default.png';
		//}
            $fname=$lname='';
        $sql2 = "SELECT * FROM admin WHERE id='".$_SESSION['id']."' ";
        $result2 = mysqli_query($conn,$sql2);
        $rows = mysqli_fetch_assoc($result2);
		  
		$sql="INSERT INTO `department`(`username`, `password`, `firstname`, `lastname`, `image`, `created_on`, `expiry_date`, `status`,`admin_id`,`department_name`,`valid_pass`,`email`) VALUES ('".$unm."','".$pass."','".$fname."','".$lname."','".$productimage."','".date('Y-m-d')."','".$rows['expiry_date']."','".$rows['status']."','".$_SESSION['id']."','".$department_name."','".$valid_pass."','".$email."')"; 
        if(mysqli_query($conn,$sql))
          {
            $_SESSION['reply']='success';
            echo '<script>window.location="department.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="adddepartment.php"</script>';
          }  
	       
      }
?>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Department</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Department</li>
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
                               Something Goes Wrong
                            </div>
                        <?php unset($_SESSION["reply"]); } ?> 
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Login </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="txtEmpName" onkeypress="return AvoidSpace(event)" name="unm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">email </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="val-email" name="email" value=""  required>
                                            </div>
                                        </div>
									
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Password </label>
                                            <div class="col-lg-6">
                                                <input type="Password" class="form-control" id="val-pass" name="pass" value=""  required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Department Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-department_name" name="department_name" required>
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
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
<script>
    function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
</script>