<?php 
session_start();
    ob_start();
       include("connect.php");
       
    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        if(isset($_POST['btn_update']))
        {
            $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE status = '0'");
            while($row = mysqli_fetch_array($results))
            {
                if($_POST['task_name'] == $row['assign_name'])
                {
                    $results1 = mysqli_query($conn,"SELECT * FROM employees WHERE eid = '".$row['eid']."'");
                    while($row1 = mysqli_fetch_array($results1))
                    {
                        date_default_timezone_set("Asia/Kolkata");  

                        $from = strtotime($row['start_date']);
                        $today = time();
                        $difference = $today - $from;
                        $days = floor($difference / 86400)+1;                     

                        $updated = mysqli_query($conn,"UPDATE tbl_task_status SET 
                        emp_name='".$row1['firstname']." ".$row1['lastname']."',task_name='".$_POST['task_name']."',task_status='".$_POST['task_status']."',remark='".$_POST['remark']."',today_date='".date("Y/m/d")."',update_time='".date("h:i:sa")."',working_days='$days' WHERE id= '$id'");

                        if($updated)
                        {
                            header("Location:emp_task_status.php");
                        }
                    }
                }
            }
        }
    }

    ob_end_flush();
?>


   <?php     
      include("header.php");
      include("sidebar.php");
   ?>
   

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Update Task Status</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Update Task Status</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                               
                               <?php
                                include('connect.php');
                                $result = mysqli_query($conn,"SELECT * FROM tbl_task_status WHERE id='".$_GET['id']."'");
                                //print_r($result);
                                $row= mysqli_fetch_array($result);
                                    
                              ?>  

                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Task Name </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="task_name">
                                                    <option value="<?php echo $row['task_name']?>"><?php echo $row['task_name']?></option>

                                                    <?php 
                                                        $results1 = mysqli_query($conn,"SELECT * FROM tbl_task WHERE status = '0'");

                                                        while($row1 = mysqli_fetch_array($results1))
                                                        {
                                                            if($row['task_name'] != $row1['assign_name'])
                                                            {
                                                    ?>
                                                        <option value="<?php echo $row1['assign_name'];?>"><?php echo $row1['assign_name'];?></option>
                                                    <?php 
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Task Status </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="task_status">
                                                    <option value="<?php echo $row['task_status']?>"><?php echo $row['task_status']?></option>

                                                    <?php 
                                                        if($row['task_status'] == "Partially Done")
                                                        {
                                                    ?>
                                                    <option value="Fully Done">Fully Done</option>
                                                    <?php 
                                                        }else if($row['task_status'] == "Fully Done")
                                                            {
                                                    ?>
                                                    <option value="Partially Done">Partially Done</option>
                                                    <?php 
                                                            }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Remark </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" name="remark"><?php echo $row['remark']?></textarea>
                                            </div>
                                        </div>

                                        <!--  -->
                                      
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
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
<?php include("footer.php"); ?>

