<?php 
//session_start();
    include("connect.php");
      if(isset($_POST['btn_submit']))
      {       
       	$eid = $_POST['emp_name']; 
        if($_GET['task'] == "deadline_Task")
        {
            header('location:assign_task.php?emp_id='.$eid.'');

        }else if($_GET['task'] == "today_Task")
        {
            header('location:assign_todays_task.php?emp_id='.$eid.'');
        }
      }
?>

<?php 
    
      include("header.php");
      include("sidebar.php");
   ?>
 <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Select Employee</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Select Employee</li>
                    </ol>
                </div>
            </div>
             
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    <form class="form-valide"  method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Employee Name </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="emp_name" name="emp_name">
                                                    <?php
                                                     include("connect.php");
                          												    $query = "select * from employees";
                          												    $results = mysqli_query($conn,$query);

                          												    while ($rows = mysqli_fetch_array($results)){ 

                          												    ?>
                          												    <option value="<?php echo $rows['eid'];?>"><?php echo $rows['firstname'];?></option>

                          												    <?php
                          												    } 
                          												    ?>
                          										    </select>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="btn_submit">Assign Task</button>
                                            </div>
                                        </div>
                                    </form>
                                    
								<?php 
							
								        mysqli_close($conn);
								    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
</div>
   <?php include("footer.php"); 
 
   ?>
   