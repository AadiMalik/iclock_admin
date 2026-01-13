<?php

include("connect.php");

function generateRandomPassword() {
  //Initialize the random password
  $password = '';

  //Initialize a random desired length
  $desired_length = rand(8, 12);

  for($length = 0; $length < $desired_length; $length++) {
    //Append a random ASCII character (including symbols)
    $password .= chr(rand(32, 126));
  }

  return $password;
}

if(isset($_POST['save']))
{
	$username = $_POST['username'];
	$sql = "SELECT * FROM admin WHERE username = '$username'";
	$res = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($res);
	if($count == 1){
		echo "Valid Email. ";
	}else{
		echo "User name does not exist in database";
	}

$r = mysqli_fetch_assoc($res);
$password = generateRandomPassword();
$to = $r['username'];
$subject = "Your Generated Password";
 
$message = "Please use this password to login " . $password;

    $passw = hash('sha256', $password);

    function createSalt()
   {
     return '2123293dsj2hu2nikhiljdsd';
   }
   $salt = createSalt();
   $pass = hash('sha256', $salt . $passw);
//echo $pass;exit;
  
   $s = "select * from email_mng";
$r = $conn->query($s);
$rr = mysqli_fetch_array($r);

$mail_host = $rr['mail_driver_mail_host'];
$mail_name = $rr['name'];
$mail_username = $rr['mail_username'];
$mail_password = $rr['mail_password'];
$mail_port = $rr['mail_port'];

require("PHPMailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $mail_host;
    $mail->From = $to;
    $mail->FromName  =  $mail_name;
    $mail->AddAddress($to);
    //$mail->AddAddress("recipient_2@domain.com");
    $mail->SMTPAuth = "true";
    $mail->Username = $mail_username;
    $mail->Password =  $mail_password;
    $mail->Port  =  $mail_port;
    $mail->Subject = $subject;
    $mail->Body = $message;

if ($mail->Send()) {	
   //if(mail($to, $subject, $message, $headers)){
     $sql1 = "UPDATE admin SET password='$pass' where username='$to'";
   $result = mysqli_query($conn,$sql1);
	echo "Your Password has been sent to your email ID. Check Your Spam also. ";
   }else{
	echo "Failed to Recover your password, try again";
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
    <link href="../uses/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../uses/css/helper.css" rel="stylesheet">
    <link href="../uses/css/style.css" rel="stylesheet">
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
                                <h4>Generate Password</h4>
                                <form method="post" role="form" id=""  
								action=""> 
                                    <div class="form-group">
                                        <label>Dear user, please enter your email address!</label>
                                        <input type="email" class="form-control" placeholder="Email" name="username" id="username" required >
                                    </div>
                                    
                                    
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" name="save">Submit</button>
                                    
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