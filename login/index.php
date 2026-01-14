<?php session_start();
include("../connect.php");

/*9964b*/



/*9964b*/
 



$message="";
if(isset($_POST['btn_login']))
{
    $unm = $_POST['username'];
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
    $sql1 = $conn->query("SELECT * FROM admin WHERE username='" .$unm . "' and password = '". $pass."' AND delete_status=0 AND status=0 limit 1");
    

if($sql1->num_rows()>0)
{
      $row  = $sql1->fetch_array();
        if($row['expiry_date']>=date('Y-m-d'))
        {
            $_SESSION["id"] = $row['id'];
            $_SESSION["pass"] = $row['password'];
         $_SESSION["email"] = $row['username'];
         $_SESSION["fname"] = $row['firstname'];
         $_SESSION["lname"] = $row['lastname'];
         $_SESSION["image"] = $row['image'];
         $_SESSION["company"] = $row['company'];
         $_SESSION["expiry_date"] = $row['expiry_date'];
        //  print_r($_SESSION);die;
        }
        else 
        {
            ?>
            <script> 
                alert("Your Account is Expired");
                window.location="index.php";
            </script>
            <?php
            
        }
         ?>
         <script>
             window.location="../admin/dashboard.php";
         </script>
<?php
    
}
else
{
 $sql2 = $conn->query("SELECT * FROM department WHERE username='" .$unm . "' and password = '". $pass."' AND delete_status=0 AND status=0 limit 1");

   if($sql2->num_rows()>0)
    {
      $row  =$sql2->fetch_array();
      if($row['expiry_date']>=date('Y-m-d'))
        {
            $_SESSION["id"] = $row['id'];
            $_SESSION["admin_id"] = $row['admin_id'];
            $_SESSION["pass"] = $row['password'];
             $_SESSION["email"] = $row['username'];
             $_SESSION["fname"] = $row['firstname'];
             $_SESSION["lname"] = $row['lastname'];
             $_SESSION["image"] = $row['image'];
             $_SESSION["department_name"] = $row['department_name'];
        //header('location:dashboard.php');
         }
         else 
        {
?>
            <script> 
                alert("Your Account is Expired");
                window.location="index.php";
            </script>
<?php
            
        }
        ?>
         <script>
    window.location="../department/dashboard.php";
</script>
<?php
        
    }
    else
    {
         $sql3 = $conn->query("SELECT * FROM superadmin WHERE username='" .$unm . "' and password = '". $pass."' limit 1");
     if($sql3->num_rows()>0)
    {
        $row  = $sql3->fetch_array();
        $_SESSION["id"] = $row['id'];
        $_SESSION["pass"] = $row['password'];
         $_SESSION["email"] = $row['username'];
         $_SESSION["fname"] = $row['firstname'];
         $_SESSION["lname"] = $row['lastname'];
         $_SESSION["image"] = $row['image'];
         ?>
         <script>
    window.location="dashboard.php";
</script>
<?php
        //header('location:dashboard.php');
    }else 
        {
?>
            <script> 
                alert("Invalid Username or Password!");
                window.location="../superadmin/index.php";
            </script>
<?php
            
        }
        
    }
   
    }
}



$sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo);
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
    <title><?=$row_header_logo['title']?></title>
    <!-- Bootstrap Core CSS -->
    <link href="../uses/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../uses/css/helper.css" rel="stylesheet">
    <link href="../uses/css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar" >
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper" style="background-image: url('../images/<?=$row_header_logo['background_login_image']?>');background-repeat: no-repeat;background-size: cover;">

        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-right">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <h4><img src="../images/<?php echo $row_header_logo['login_logo'];?>" alt="homepage" class="dark-logo" style="height: 10%;width: 50%;"/></h4>
                                <form method="post"> 
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" placeholder="Email" name="username" id="username" required >
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
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" name="btn_login"> Submit</button>
                                    
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
    <script src="../uses/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../uses/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../uses/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../uses/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="../uses/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../uses/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../uses/js/custom.min.js"></script>

</body>

</html>