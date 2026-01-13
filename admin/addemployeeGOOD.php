<?php 
    
      include("header.php");
      include("sidebar.php");
?>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add Employee</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Employee</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
<?php
    
    include('connect.php');
    if(isset($_POST['save'])){
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $birthdate = $_POST['date'];
        $contact = $_POST['phone'];
        $gender = $_POST['gender'];
        $position = $_POST['position'];
        $rate = $_POST['rate'];
        $schedule = $_POST['schedule'];
        $department_id = $_POST['department_id'];
        $leave = $_POST['leave'];
        $leavediff = number_format(365 / $leave);
        $sick_allot_leave=$_POST['sick_allot_leave'];
        $imgFile = $_FILES['image']['name'];
        $tmp_dir = $_FILES['image']['tmp_name'];
        $imgSize = $_FILES['image']['size'];
        if(empty($imgFile)){
            $errMSG = "Please Select Image File.";
        }
        else
        {
            $upload_dir = 'uploaded/employee/';
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
            $image = rand(1000,1000000).".".$imgExt;
            if(in_array($imgExt, $valid_extensions)){
                if($imgSize < 5000000)              {
                    
                    move_uploaded_file($tmp_dir,$upload_dir.$image);
                }
                else{
                    $errMSG = "Sorry, Your File Is Too Large To Upload. It Should Be Less Than 5MB.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF Extension Files Are Allowed.";      
            }
        
        }
    
        
        
        //creating employeeid
        $letters = '';
        $numbers = '';
        foreach (range('A', 'Z') as $char) {
            $letters .= $char;
        }
        for($i = 0; $i < 10; $i++){
            $numbers .= $i;
        }
        $employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0,5);
        //
        
        /*$q = mysqli_query($conn,"SELECT * FROM employees WHERE contact_info='$contact'");
        $data = $q->num_rows;
        if(($data)==0){*/
            $pin='1234';
        $passw = hash('sha256', $pin);
        function createSalt()
           {
            return '2123293dsj2hu2nikhiljdsd';
           }
          $salt = createSalt();
          $pass = hash('sha256', $salt . $passw);
        
        $sql = "INSERT INTO employees (eid,admin_id, employee_id,password, firstname, lastname,email, address, birthdate, contact_info, gender, position_id, rate, schedule_id, allot_leave, avail_leave, leave_difference,sick_allot_leave,sick_avail_leave, image, created_on,expiry_date,department_id,pin) VALUES ('','".$_SESSION['id']."','$employee_id','$pass', '$firstname', '$lastname', '$email', '$address', '$birthdate', '$contact', '$gender', '$position', '$rate', '$schedule', '$leave','$leave' ,'$leavediff','$sick_allot_leave','$sick_allot_leave', '$image', NOW(),'".$_SESSION["expiry_date"]."','$department_id','$pin')"; 
        
        $result= mysqli_query($conn,$sql);
        
        if($result)
           {    
           /*header('location:employeelist.php'); */ 
?>
            <script>
                window.location="employeelist.php";
            </script>
<?php
              // echo "Record inserted successfully";
           }
           else
           mysql_error();
           
        /*}
        else{
           echo "This employee is already registered, Please try another contact_info ";
            }*/
           mysqli_close($conn);
         
}
    ?>  

    


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
                                            <label class="col-lg-4 col-form-label" for="val-username">Firstname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="fname" placeholder="Enter Firstname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Lastname </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-lastname" name="lname" placeholder="Enter Lastname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Email </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="val-email" name="email" placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Address </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Address" name="address"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Birth Date </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-contact">Contact Info</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-contact" name="phone" placeholder="Enter Contact No.">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Gender </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-gender" name="gender">
                                                    <option value="">Please select</option>
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
                                                      $sql = "SELECT * FROM department where admin_id='".$_SESSION['id']."' and delete_status=0";
                                                      $query = mysqli_query($conn,$sql);
                                                      while($prow = mysqli_fetch_assoc($query)){
                                                        echo "
                                                          <option value='".$prow['id']."'>".$prow['department_name']."</option>
                                                        ";
                                                      }
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
                                                      while($prow = mysqli_fetch_assoc($query)){
                                                        echo "
                                                          <option value='".$prow['id']."'>".$prow['description']."</option>
                                                        ";
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-rate">Rate per Day</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-rate" name="rate" placeholder="Enter Rate Per Day" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Schedule</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-schedule" name="schedule" required>
                                                    <option value="" selected>Please select</option>
                                                    <?php
                                                      $sql = "SELECT * FROM schedules WHERE admin_id='".$_SESSION['id']."'";
                                                      $query = mysqli_query($conn,$sql);
                                                      while($srow = mysqli_fetch_assoc($query)){
                                                        echo "
                                                          <option value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
                                                        ";
                                                      }
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-leave">Allotted Leave</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-leave" name="leave" placeholder="Enter Allotted Leave" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-leave">Sick Allotted Leave</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-sick_allot_leave" name="sick_allot_leave" placeholder="Enter Sick Allotted Leave" required>
                                            </div>
                                        </div>
                                        
                                      <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">Photo</label>
                                            <div class="col-lg-6">
                                               <input type="file" class="form-control" id="val-file" name="image" placeholder="Choose a file"> 
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