<?php
session_start();
include("connect.php");
$message="";
if(isset($_POST['login']))
{
    $unm = $_POST['emp_id'];
    //$p="admin";
    $passw = hash('sha256', $_POST['passwd']);
    //$passw = hash('sha256',$p);
    //echo $passw;exit;
    function createSalt()
    {
        return '2123293dsj2hu2nikhiljdsd';
    }
    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);
    //echo $pass;exit;
    $sql = "SELECT * FROM employees WHERE  employee_id='" .$unm . "' and password = '". $pass."'";
    $result = mysqli_query($conn,$sql);
    $row  = mysqli_fetch_array($result);
    $_SESSION["empid"] = $row['eid'];
    $_SESSION["pass"] = $row['password'];
     //$_SESSION["email"] = $row['username'];
    $_SESSION["fname"] = $row['firstname'];
    $_SESSION["lname"] = $row['lastname'];
    $_SESSION["image"] = $row['image'];
    $count=mysqli_num_rows($result);

    if(count($result)==1 && isset($_SESSION["empid"]) && isset($_SESSION["pass"])) 
    {     
        date_default_timezone_set("Asia/Kolkata");
        $result_emp_atten = mysqli_query($conn,"SELECT * FROM attendance WHERE employee_id='" .$row['eid']. "' && date = '".date('Y-m-d')."'");
        if(mysqli_num_rows($result_emp_atten) > 0)
        {  
?>
            <script>
                window.location="emp_dashboard.php";
            </script>
<?php
        }else{
?>
                <script>                    
                    alert("Only Present Employee can Login");
                    window.location="employee_index.php";
                </script>
<?php
            }
    }else 
    {
?>
        <script> 
            alert("Invalid Username or Password!");
            window.location="employee_index.php";
        </script>
<?php
        $message = "Invalid Username or Password!";
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Attendance Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">

        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <h4>Login</h4>
                                <form method="post" role="form" id="login" > 
                                    <div class="form-group">
                                        <label>Employee ID</label>
                                        <input type="text" class="form-control" placeholder="" name="emp_id" id="username" required >
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="passwd" id="passwd" required>
                                    </div>
                                    <div class="checkbox">
                                        
                                            <label class="pull-right">
        										<a href="generatepass.php">Generate Password?</a>
        									</label>

                                    </div>
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" name="login">Sign in</button>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

</body>

</html>