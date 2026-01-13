<?php    
    include('connect.php');
    include("header.php");
    include("sidebar.php");
?>
<?php 
    if(isset($_POST['btn_update']))
    {
        $sql = mysqli_query($conn,"UPDATE email_mng SET name='".$_POST['name']."', mail_driver_mail_host='".$_POST['mail_driver_mail_host']."', mail_port='".$_POST['mail_port']."',mail_username='".$_POST['mail_username']."',mail_password='".$_POST['mail_password']."',mail_encryption='".$_POST['mail_encryption']."'");

        if ($sql) 
        {
            $msg = "Email Management Updated Successfully.";
            //header("location:email_mng.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
      
?>
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Email Management</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Email Management</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    <?php
                                    if(isset($msg))
                                    {
                                ?>
                                <div class="row" id="success_div">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                       <div class="alert alert-success alert-success-style1 alert-st-bg">
                                            <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                                                    <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                                                </button>
                                            <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-clr" aria-hidden="true"></i>
                                            <p><strong>Success!</strong>&nbsp;&nbsp;<?php echo $msg;?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    }
                                ?>
                                    <form method="post">
                                        <div class="row">
                                            <?php 
                                                $sql = "SELECT * FROM email_mng";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) 
                                                {
                                                    while($row = $result->fetch_assoc()) 
                                                    {
                                                        
                                            ?>
                                           
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-username">Name </label>
                                                     <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $row['name'];?>">
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">Mail Driver Mail Host </label>
                                                    <input type="text" class="form-control" placeholder="Mail Driver Mail Host" name="mail_driver_mail_host" value="<?php echo $row['mail_driver_mail_host'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-address">Mail Port  </label>
                                                    <input type="text" class="form-control" placeholder="Mail Port" name="mail_port" value="<?php echo $row['mail_port'];?>">
                                                </div>


                                                
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                               
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Mail Username</label>
                                                    <input type="text" class="form-control" placeholder="Mail Username" name="mail_username" value="<?php echo $row['mail_username'];?>">
                                                </div>  

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Mail Password</label>
                                                    <input type="password" class="form-control" placeholder="Mail Password" name="mail_password" value="<?php echo $row['mail_password'];?>">
                                                </div> 

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Mail Encryption</label>
                                                    <input type="text" class="form-control" placeholder="Mail Encryption" name="mail_encryption"value="<?php echo $row['mail_encryption'];?>">
                                                </div>
                                               
                                            </div>

                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-2 ml-auto">
                                                <input type="submit" class="btn btn-primary" name="btn_update" value="Update" id="btn_update">
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
        </div>

        
<?php include "footer.php"; ?>