<?php
	include('../connect.php');
	ob_start();
	
	if(isset($_POST["update"]))
   {
	extract($_POST);
	
	$unm = $_POST['unm'];
    $department_name = $_POST['department_name'];

   function createSalt()
   {
    return '2123293dsj2hu2nikhiljdsd';
   }
  if($_POST['pass']!='')
  {
    $valid_pass=$passw1 = $_POST['pass'];
    $passw = hash('sha256', $passw1);
    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);
  }
  else
  {
    $pass=$_POST['my_password'];
    $valid_pass=$_POST['my_valid_pass'];
  }
  
          /*$imgFile = $_FILES['photo']['name'];
		  $tmp_dir = $_FILES['photo']['tmp_name'];
		  $imgSize = $_FILES['photo']['size'];
	      if($imgFile)
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
		{
			$productimage=$_POST['my_file'];
		}*/
		  
		$sql="UPDATE department SET 
                username='$unm',password='$pass',department_name='$department_name',valid_pass='$valid_pass',email='$email' WHERE id='".$_GET['id']."'";   
		if(mysqli_query($conn,$sql))
          {
            
            $_SESSION['reply']='success';
            echo '<script>window.location="department.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="editdepartment.php?id='.$_GET['id'].'"</script>';
          }  
       
	       
      }
	   
	   ob_end_flush();
?>
	
<?php


$sql2 = "SELECT * FROM department WHERE id='".$_GET['id']."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {

    while($rows = mysqli_fetch_assoc($result2)) {
	
	$uname = $rows['username'];
	$password1 = $rows['password'];
	$firstnm = $rows['firstname'];
	$lastnm = $rows['lastname'];
	$file = $rows['image'];
    $department_name = $rows['department_name'];
    $email = $rows['email'];
    $valid_pass = $rows['valid_pass'];
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
                                        <input type="hidden" name="my_password" value="<?php echo $password1; ?>">
                                        <input type="hidden" name="my_valid_pass" value="<?php echo $valid_pass; ?>">
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Login </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" onkeypress="return AvoidSpace(event)" name="unm" value="<?php echo $uname; ?>" required>
                                            </div>
                                        </div>
									
									    <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Password </label>
                                            <div class="col-lg-6">
                                                <input type="Password" class="form-control" id="val-pass" name="pass" value="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">email </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="val-email" name="email" value="<?php echo $email; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Department Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-department_name" name="department_name" value="<?php echo $department_name; ?>"  required>
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
            <script>
    function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
</script>
