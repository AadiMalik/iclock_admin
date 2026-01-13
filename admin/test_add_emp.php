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
        
        $sql = "INSERT INTO employees (eid,admin_id, employee_id,password, firstname, lastname,email, address, birthdate, contact_info, gender, position_id, rate, schedule_id, allot_leave, avail_leave, leave_difference,sick_allot_leave,sick_avail_leave, image, created_on,expiry_date,department_id,pin) 
        VALUES ('','14','$employee_id','$pass', '$firstname', '$lastname', '$email', '$address', '$birthdate', '$contact', '$gender', '$position', '$rate', '$schedule', '$leave','$leave' ,'$leavediff','$sick_allot_leave','$sick_allot_leave', '$image', NOW(),'0000-00-00','$department_id','$pin')"; 
        
        $result= mysqli_query($conn,$sql);
        
        if($result)
           {    
           /*header('location:employeelist.php'); */ 
?>
            <script>
            alert("added");
                // window.location="employeelist.php";
            </script>
<?php
              // echo "Record inserted successfully";
           }
           else
           {?>
               <script>
            alert("Error");
                // window.location="employeelist.php";
            </script>
            <?php
          echo   mysqli_error($conn);
           }
          
           
        /*}
        else{
           echo "This employee is already registered, Please try another contact_info ";
            }*/
           mysqli_close($conn);
         
}
    ?>  
