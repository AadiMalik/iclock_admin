<?php
    ob_start();
       include("connect.php");
       if(isset($_GET['emer_task_id']))
       {
         $id=$_GET['emer_task_id'];
        if(isset($_POST['update'])){
        $assign = $_POST['assgn_name'];
        $module = $_POST['module_details'];
        $desc = $_POST['desc'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        //$gender = $_POST['gender'];
        
        //creating employeeid
       
        /*$sql = "INSERT INTO tbl_task(assign_name, module_details, description, start_date,  end_date) VALUES ('$assign', '$module', '$desc', '$start_date', '$end_date')";
        $result= mysqli_query($conn,$sql);*/
        
         $updated = mysqli_query($conn,"UPDATE tbl_emergency SET 
                assignment_name='$assign',module_desc='$module',description='$desc',start_date='$start_date',end_date='$end_date' WHERE emer_task_id= '$id'");
         
       if($updated)
      {
         header("Location:emergencytasklist.php");
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
                    <h3 class="text-primary">Update Emergency Task</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Update Emergency Task</li>
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
                                        $result = mysqli_query($conn,"SELECT * FROM tbl_emergency WHERE emer_task_id='".$_GET['emer_task_id']."'");
                                        //print_r($result);
                                        $row= mysqli_fetch_array($result);
                                        
                                        
                                  ?>  

                                <div class="form-validation">
                                    <form class="form-valide"  method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Emergency Task ID </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="emer_id" disabled="" value="<?php echo $row['emer_task_id']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Assignment Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="assgn_name" value="<?php echo $row['assignment_name']; ?>" required>
                                            </div>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Module Details </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="module_details"><?php echo $row['module_desc']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Description  </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="desc"><?php echo $row['description']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Start date</label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">End date</label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>">
                                            </div>
                                        </div>

                                        <!--  -->
                                      
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="update">Update</button>
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