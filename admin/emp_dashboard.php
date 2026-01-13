<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>
<?php 
	 
	  include('connect.php');
	  include("header_emp.php");
      include("sidebar_emp.php");
?>


 
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php 
                    include('connect.php'); 
                    date_default_timezone_set("Asia/Kolkata");
                    $date = date("Y-m-d");
                    $tomorrow_date = date('Y-m-d', strtotime('+1 day', strtotime($date)));

                    $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE status = '0' && eid='".$_SESSION["empid"]."'");
                    if(mysqli_num_rows($results) > 0)
                    {
                        while($row = mysqli_fetch_array($results))
                        {
                            if($row['end_date'] == $tomorrow_date)
                            {
                ?>
                        
                <div>
                    <div class="alert alert-success alert-dismissible mt20 text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span class="result"><i class="fa fa-tachometer" style="color: blue"></i> <span class="message" style="color: blue">&nbsp;&nbsp;Tomorrow Deadline of project :- <?php echo $row['assign_name']?>   &nbsp;&nbsp;</span></span><i class="fa fa-tachometer" style="color: blue"></i>
                        
                    </div>
                </div>

                <?php   
                            if($row['deadline_alert'] == '0')
                            {     
                                mysqli_query($conn, "UPDATE tbl_task SET deadline_alert='1' WHERE id='".$row['id']."'");      
                                      
                                $sql_email_mng = "SELECT * FROM email_mng";
                                $result = $conn->query($sql_email_mng);
                                $row_email = mysqli_fetch_array($result);
                                      
                                require_once('../PHPMailer/PHPMailerAutoload.php');
                                $mail = new PHPMailer;
                                $mail->isSMTP();   
                                
                                $mail->Host = $row_email['mail_driver_mail_host']; 
                                $mail->SMTPAuth = true;                              
                                $mail->Username = $row_email['mail_username'];              
                                $mail->Password = $row_email['mail_password'];                           
                                $mail->SMTPSecure = 'tls';
                                $mail->Port = $row_email['mail_port'];       
                                $mail->setFrom($row_email['mail_username'], 'UPTURNIT');
                                $mail->addAddress('ktm.upturnit@gmail.com', 'kanchan');

                                $mail->Subject = 'Project Deadline Alert';
                                $mail->Body    = "Tomorrow is Deadline of Project :- ".$row['assign_name'];
                                $mail->send();
                            }
                        }else{
                            mysqli_query($conn, "UPDATE tbl_task SET deadline_alert='0' WHERE id='".$row['id']."'"); 
                        }
                    }
                }

                ?>

                
                <ul class="uu" style="">
                    <?php

                        $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE eid='".$_SESSION["empid"]."' && status='0'");
                       
                        while($row = mysqli_fetch_array($results))
                        {
                            extract($row);
                            //$_SESSION['mod_id'] = $row['module_id'];
                    ?>
                            
                            <li><a href="display_emp_modules.php?mod_id=<?php echo $row['task_id'];?>"><h2><?php echo $row['assign_name']; ?></h2>
                                <p><?php echo $row['description']; ?></p></a></li>
                                
                    <?php 
                        }
                    
                        $results_todays_task = mysqli_query($conn,"SELECT * FROM tbl_todays_task WHERE eid='".$_SESSION["empid"]."' && task_assign_date = '$date' && status='0'");
                       
                        while($row_todays_task = mysqli_fetch_array($results_todays_task))
                        {
                            extract($row_todays_task);
                            //$_SESSION['mod_id'] = $row['module_id'];
                    ?>
                            
                            <li><a href="display_emp_modules.php?mod_id=<?php echo $row_todays_task['task_id'];?>"><h2><?php echo $row_todays_task['assign_name']; ?></h2><p><?php echo $row_todays_task['description']; ?></p></a></li>
                                
                    <?php 
                        }
                    ?>

            </ul>
                     
            </div>
            <!-- End Container fluid  -->
         </div>
          
			<?php include("footer.php"); ?>
			
