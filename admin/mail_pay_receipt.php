<?php
	include "connect.php";
 	require_once('../PHPMailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    $mail->isSMTP();   

    $sql_email_mng = "SELECT * FROM email_mng";
    $result = $conn->query($sql_email_mng);
    $row_email = mysqli_fetch_array($result);
    
    $mail->Host = $row_email['mail_driver_mail_host']; 
    $mail->SMTPAuth = true;                              
    $mail->Username = $row_email['mail_username'];              
    $mail->Password = $row_email['mail_password'];                           
    $mail->SMTPSecure = 'tls';
    $mail->Port = $row_email['mail_port'];       
    $mail->setFrom($row_email['mail_username'], 'UPTURNIT');
    $mail->addAddress($_POST['client_email'], 'kanchan');

    $mail->Subject = 'Payment Receipt';
    $mail->Body    = str_replace("<br>","\n",$_POST['area1']);
    if($mail->send())
    {
?>
		<script type="text/javascript">
            window.location.href = "inv_payment_receipt.php?qut_id=<?php echo $_GET['qut_id'];?>";
        </script>
<?php
    }
?>