<?php   
include("connect.php");
  if(isset($_GET['id']))
  {
  $id=$_GET['id'];
 
  $getselect=mysqli_query($conn,"SELECT employees.*,department.department_name  FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN department ON department.id=employees.department_id WHERE employees.eid = '$id'");
 
  while($rows = mysqli_fetch_array($getselect))
  {
    $uname = $rows['employee_id'];      
    $emp_photo = $rows['image'];
    $name = $rows['firstname'].' '.$rows['lastname'];
    $emp_address = $rows['address'];
    $emp_birth = $rows['birthdate'];
    $emp_contact = $rows['contact_info'];
    $email = $rows['email'];
    $pid = $rows['position_id'];
    $department_name = $rows['department_name'];
    $pin = $rows['pin'];
    $sid = $rows['schedule_id'];
  }
 $sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo); 

 
$message='
<center>
  <img src="http://iclock.idamru.net/admin/images/iclock.png" style="width: 10%;height: 10%;"><br>
  <h1>Welcome To '.$row_header_logo['title'].'</h1>
</center>
  <span>Department : '.$department_name.'</span>
  <p>Dear '.$name.'</p>
  <p>Your user ID is <b>'.$uname.'</b> and your default password is <b>'.$pin.'</b>. Please use your user ID and password to login to <a href="https://iclock.mu">https://iclock.mu</a></p>
  <p>Please note that your USER ID is personal to you and should not be communicated to any third party or your password transferred to anybody. <b>ICLOCK</b> is one-stop web interface to enable you to log in and log out your time. You may also apply for leave and check your remaining leaves.</p>
  <p> The iclock app is now available in Android version and can be downloaded at the following link https://play.google.com/store/apps/details?id=com.mu.iclock_app </p>
  <br>
  <span>For any information or query please send email to team@idamru.com or call : </span><br>
  T : +230 215 2977 
 ';  
$s = "select * from email_mng";
$r = $conn->query($s);
$rr = mysqli_fetch_array($r);
$mail_host = $rr['mail_driver_mail_host'];
$mail_name = $rr['name'];
$mail_username = $rr['mail_username'];
$mail_password = $rr['mail_password'];
$mail_port = $rr['mail_port'];
// require("PHPMailer/class.phpmailer.php");
//     $mail = new PHPMailer();
//     $mail->SMTPDebug = 1;
//     $mail->IsSMTP();
//     $mail->Host = $mail_host;
//     $mail->From = $mail_username;
//     $mail->FromName  =  $mail_name;
//     $mail->AddAddress($email);
//     //$mail->AddAddress("recipient_2@domain.com");
//     $mail->SMTPAuth = "true";
//     $mail->Username = $mail_username;
//     $mail->Password =  $mail_password;
//     $mail->Port  =  $mail_port; 
//     $mail->Subject = 'Your Confidential Details';
//     $mail->Body = $message;
//     $mail->IsHTML(true);
    $headers = "From: noreply@idmaru.net" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $to = $email;
    $subject = 'Your Confidential Details';
    $email_send = mail($to,$subject,$message,$headers);
if ($email_send) {
  echo "<span style='color:green;'> Mail send successfully. Check The Spam also.</span> <a href='employeelist.php'>Back</a>";
} 
else{
  echo "<span style='color:reds;'>Failed to send Email, try again.</span> <a href='employeelist.php'>Back</a>";
        }
} 
?>
