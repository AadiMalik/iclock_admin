<?php   
include("connect.php");
  if(isset($_GET['id']))
  {
  $id=$_GET['id'];
 
  $sql2 = "SELECT * FROM department WHERE id='".$_GET['id']."' ";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
    while($rows = mysqli_fetch_assoc($result2)) {
  
  $uname = $rows['username'];
  $department_name = $rows['department_name'];
  $email = $rows['email'];
  $valid_pass = $rows['valid_pass'];
}
 $sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo); 

 
$message='
<center>
  <img src="http://myphub.com/ida/images/IDA_Clockjpg.png" style="width: 10%;height: 10%;"><br>
  <h1>Welcome To '.$row_header_logo['title'].'</h1>
</center>
  <span>Department : '.$department_name.'</span>
  <p>Dear '.$department_name.'</p>
  <p>Your Login is <b>'.$uname.'</b> and your password is <b>'.$valid_pass.'</b>. Please use your Login and password to login to <a href="http://myphub.com/ida/department">http://myphub.com/ida/department</a></p>
  <p>Please note that your Login is personal to you and should not be communicated to any third party or your password transferred to anybody. <b>ICLOCK</b> is one-stop web interface to enable you to log in and log out your time. You may also apply for leave and check your remaining leaves.</p>
  <br>
  <span>For any information or query please send email to support@idamru.com or call : </span><br>
  T : +230 263 9051/2781 | Mobile : 5 976 7898
 ';  
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
    $mail->From = $mail_username;
    $mail->FromName  =  $mail_name;
    $mail->AddAddress($email);
    //$mail->AddAddress("recipient_2@domain.com");
    $mail->SMTPAuth = "true";
    $mail->Username = $mail_username;
    $mail->Password =  $mail_password;
    $mail->Port  =  $mail_port; 
    $mail->Subject = 'Your Confidential Details';
    $mail->Body = $message;
    $mail->IsHTML(true);

if ($mail->Send()) {
  echo "<span style='color:green;'> Mail send successfully. Check The Spam also.</span> <a href='department.php'>Back</a>";
} 
else{
  echo "<span style='color:reds;'>Failed to send Email, try again.</span> <a href='department.php'>Back</a>";
        }
} ?>
