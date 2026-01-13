<?php
session_start();

include("../connect.php");
$message="";
/*if(isset($_POST['btn_login']))
{*/
    $unm = $_POST['employee'];
    //$p="admin";
    $passw = hash('sha256', $_POST['passwd1']);
    //$passw = hash('sha256',$p);
    //echo $passw;exit;
    function createSalt()
    {
        return '2123293dsj2hu2nikhiljdsd';
    }
    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);
    //echo $pass;exit;
   $sql = "SELECT * FROM employees WHERE employee_id='" .$unm . "' and password = '". $pass."' AND status=0";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {

        $row  = mysqli_fetch_array($result);
        if($row['expiry_date']>=date('Y-m-d'))
        {
            $_SESSION["id"] = $row['eid'];
            $_SESSION["admin_id"] = $row['admin_id'];
            $_SESSION["pass"] = $row['password'];
             $_SESSION["email"] = $row['employee_id'];
             $_SESSION["fname"] = $row['firstname'];
             $_SESSION["lname"] = $row['lastname'];
             $_SESSION["image"] = $row['image'];
             $_SESSION["department_id"] = $row['department_id'];
            $output['message'] = 'Welcome';   
         }
         else 
        {
            $output['error'] = true;
            $output['message'] = 'Your Account is Expired';           
        }
    }else 
        {
            $output['error'] = true;
            $output['message'] = 'Invalid Employee ID or Password!';   
        }
        echo json_encode($output);
//}
?>