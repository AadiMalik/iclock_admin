<?php
include("header.php");
include("sidebar.php");
    ob_start();
       include("connect.php");
       if(isset($_GET['id']))
       {
         $id=$_GET['id'];
         
        if(isset($_POST['update']))
        {
        $firstname = $_POST['fname'];
         $isactive = $_POST['isactive'];
        $lastname = $_POST['lname'];
        $address = $_POST['address'];
        $birthdate = $_POST['date'];
        $contact = $_POST['phone'];
        $gender = $_POST['gender'];
        $position = $_POST['position'];
        $rate = $_POST['rate'];
        $email = $_POST['email'];
        $schedule = $_POST['schedule'];
        $department_id = $_POST['department_id'];
        
          $imgFile = $_FILES['image']['name'];
          $tmp_dir = $_FILES['image']['tmp_name'];
          $imgSize = $_FILES['image']['size'];
          if($imgFile)
          {
            $upload_dir = 'uploaded/employee/';
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
            $image = rand(1000,1000000).".".$imgExt;
            if(in_array($imgExt, $valid_extensions))
            {           
                if($imgSize < 5000000)
                {
                    @unlink($upload_dir.$_POST['old_slider']);
                    move_uploaded_file($tmp_dir,$upload_dir.$image);
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
            $image=$_POST['old_slider'];
        }
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
        $pin= $_POST['pass'];
        $updated = mysqli_query($conn,"UPDATE employees SET isActive='$isactive',
                firstname='$firstname',lastname='$lastname',address='$address',birthdate='$birthdate',contact_info='$contact',gender='$gender',position_id='$position',rate='$rate',schedule_id='$schedule',image='$image',department_id='$department_id',password='$pass',pin='$pin',expiry_date='".$_SESSION["expiry_date"]."',email='$email' WHERE eid='$id'");
       
      }
      else
      {
        $pass=$_POST['my_password'];
        $updated = mysqli_query($conn,"UPDATE employees SET isActive='$isactive',
                firstname='$firstname',lastname='$lastname',address='$address',birthdate='$birthdate',contact_info='$contact',gender='$gender',position_id='$position',rate='$rate',schedule_id='$schedule',image='$image',department_id='$department_id',expiry_date='".$_SESSION["expiry_date"]."',email='$email' WHERE eid='$id'");
       
      }
          
         if($updated)
      {
          $_SESSION['data']="Updated";
         //header("Location:employeelist.php");
         ?>
            <script>
                window.location="employeelist.php";
            </script>
<?php
      }
      else{
            
            $_SESSION['data']=$conn->error;

      }
           
      }
       }
       ob_end_flush();
?>
    

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Employee</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employee</li>
                    </ol>
                </div>
            </div>
            <?php
            if(isset($_SESSION['data']))
            {
                echo $_SESSION['data'];
                unset($_SESSION['data']);
            }
            ?>
            <?php 
  

  if(isset($_GET['id']))
  {
  $id=$_GET['id'];
 
  $getselect=mysqli_query($conn,"SELECT *, employees.rate as rt, employees.eid as empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$id'");
 
  while($rows = mysqli_fetch_array($getselect))
  {
    $uname = $rows['employee_id']; 
     $emp_isActive = $rows['isActive']; 
    $emp_photo = $rows['image'];
    $emp_fname = $rows['firstname'];
    $emp_lname = $rows['lastname'];
    $emp_address = $rows['address'];
    $emp_birth = $rows['birthdate'];
    $emp_contact = $rows['contact_info'];
    $emp_gender = $rows['gender'];
    $pos =  $rows['description'];
    $pid = $rows['position_id'];
    $department_id = $rows['department_id'];
    $rt = $rows['rt'];
    $email = $rows['email'];
    $password1 = $rows['password'];
    $schedule = date('h:i A', strtotime($rows['time_in'])).' - '.date('h:i A', strtotime($rows['time_out'])) ;
    $sid = $rows['schedule_id'];
    
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
                                    <form class="form-valide" action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="my_password" value="<?php echo $password1; ?>">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Username </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="unm" value="<?php echo $uname; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Firstname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="fname" value="<?php echo $emp_fname; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Lastname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-lastname" name="lname" value="<?php echo $emp_lname; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Email </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="val-email" name="email" value="<?php echo $email; ?>" placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Password </label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="val-pass" name="pass" pattern="[0-9]{4}" maxlength="4" value="" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Address </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="address" required><?php echo $emp_address; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Birth Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"  value="<?php echo $emp_birth; ?>" name="date" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-contact">Contact Info</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-contact" name="phone"  value="<?php echo $emp_contact; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Gender </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-gender" name="gender" required>
                                                    <option value="<?php echo $emp_gender; ?>" <?php if(!isset($_POST['gender']) || (isset($_POST['gender']) && empty($_POST['gender']))) { ?>selected<?php } ?>><?php echo $emp_gender; ?></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Department</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-department" name="department_id" required>
                                                    <option value="">Please select</option>
                                                    <?php
                                                      $sql = "SELECT * FROM department where admin_id='".$_SESSION['id']."'";
                                                      $query = mysqli_query($conn,$sql);
                                                      while($prow = mysqli_fetch_assoc($query)){ ?>
                                                        <option value="<?php echo $prow['id']; ?>" <?php if($department_id==$prow['id']){ echo 'selected'; } ?>><?=$prow['department_name']?></option>
                                                        ";
                                                     <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Position</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-position" name="position" required>
                                                    <option value="">Please select</option>
                                                    <?php
                                                      $sql = "SELECT * FROM position where admin_id='".$_SESSION['id']."'";
                                                      $query = mysqli_query($conn,$sql);
                                                      while($prow = mysqli_fetch_assoc($query)){ ?>
                                                          <option value="<?php echo $prow['id']; ?>" <?php if($pid==$prow['id']){ echo "selected"; }?>><?php echo $prow['description']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-rate">Rate per Day</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-rate" name="rate" value="<?php echo $rt; ?>" required>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                        <?php
                                              $sql = "SELECT * FROM schedules WHERE admin_id='".$_SESSION['id']."'";
                                              $query = mysqli_query($conn,$sql);
                                        ?>
                                            <label class="col-lg-4 col-form-label" for="val-skill">Schedule</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-schedule" name="schedule" required>
                                                    <?php
                                                      while($srow = mysqli_fetch_assoc($query)){
                                                          ?>
                                                        <option value="<?php echo $srow['id']; ?>" <?php if($srow['id']==$rows['schedule_id']){echo "selected";} ?>><?php echo $srow['time_in'].' - '.$srow['time_out'] ;?></option>
                                                     <?php } ?>
                                                      
                                                    
                                                    
                                                </select>
                                            </div>
                                        </div>
                                          <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Active Status</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="" name="isactive" required>
                                                    <option value=""  >Please select</option>
                                                     <option value="0" <?php if($emp_isActive==0){echo "selected";} ?>>Active</option>
                                                      <option value="1" <?php if($emp_isActive==1){echo "selected";} ?>>In-Active</option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                      <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Photo</label>
                                            <img src="uploaded/employee/<?php echo $emp_photo; ?>" height="50" width="50" />
                                            <div class="col-lg-6">
                                               <input type="file" class="form-control" id="val-file" name="image" <?php if(!isset($emp_photo)){ echo "required"; } ?>>

                                               <input type="hidden" name="old_slider" value="<?php if(isset($emp_photo)){ echo $emp_photo; } ?>">
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <?php }}  mysqli_close($conn); ?>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <?php include("footer.php"); ?>