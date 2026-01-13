<?php       include('connect.php');
      include("header_emp.php");
      include("sidebar_emp.php");
?>
<?php
    if(isset($_POST['btn_save']))
    {
        $sql = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$_GET['mod_id']."'");    
        while ($row = mysqli_fetch_array($sql)) 
        {   
            $sql_task_status = mysqli_query($conn,"SELECT * FROM tbl_task_status WHERE status='0'");   
            $f = 0; 
            while ($row_task_status = mysqli_fetch_array($sql_task_status)) 
            {
                if($row_task_status['module_id'] == $row['id'])
                {
                    $f = 1;
                    $sql_emp = mysqli_query($conn,"SELECT * FROM employees WHERE eid='".$_SESSION['empid']."'");    
                    $row_emp = mysqli_fetch_array($sql_emp);
                    date_default_timezone_set("Asia/Kolkata");

                    mysqli_query($conn,"UPDATE tbl_task_status SET 
                    emp_id='".$row_emp['eid']."',module_id='".$row['id']."',task_status='".$_POST['sel_status'.$row['id']]."',pending_work = '".$_POST['pending_work'.$row['id']]."',last_update_date = '".date('Y-m-d')."',update_time = '".date("h:i:sa")."' WHERE module_id= '".$row['id']."'");
                }
            }

            if($f == 0)
            {                
                $sql_emp = mysqli_query($conn,"SELECT * FROM employees WHERE eid='".$_SESSION["empid"]."'");    
                $row_emp = mysqli_fetch_array($sql_emp);
                date_default_timezone_set("Asia/Kolkata");
                
                mysqli_query($conn,"INSERT INTO tbl_task_status(emp_id, module_id, task_status,pending_work, last_update_date, update_time, status) VALUES ('".$row_emp['eid']."','".$row['id']."','".$_POST['sel_status'.$row['id']]."','".$_POST['pending_work'.$row['id']]."','".date("Y/m/d")."','".date("h:i:sa")."','0')");
            }
        }


        /*******Update Task Status******/
        $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE status = '0'");

        while($row = mysqli_fetch_array($results))
        {
            $results_mod_id = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$row['task_id']."'"); 
            $no_of_module = mysqli_num_rows($results_mod_id);
            $c = 0;
            $f = 0; 
            while($row_mod_id = mysqli_fetch_array($results_mod_id))
            {                                               

            $results_task_status = mysqli_query($conn,"SELECT * FROM tbl_task_status WHERE module_id='".$row_mod_id['id']."'");
            
                if(mysqli_num_rows($results_task_status) > 0)
                {
                    while($row_task_status = mysqli_fetch_array($results_task_status))
                    {
                        if($row_task_status['task_status'] == "Fully Done")
                        {
                            $c++;     
                            if($no_of_module == $c)
                            {      
                                $f = 1;  
                                mysqli_query($conn,"UPDATE tbl_task SET 
                                task_status='Completed' WHERE task_id= '".$row['task_id']."'");
                            }

                        }
                    }
                }
            }

            if($f == 0)
            {
                mysqli_query($conn,"UPDATE tbl_task SET 
                task_status='Incomplete' WHERE task_id= '".$row['task_id']."'");
            }
        }

        /*********Update todays task Status*********/
        $results = mysqli_query($conn,"SELECT * FROM tbl_todays_task WHERE status = '0'");

        while($row = mysqli_fetch_array($results))
        {
            $results_mod_id = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$row['task_id']."'"); 
            $no_of_module = mysqli_num_rows($results_mod_id);
            $c = 0;
            $f = 0; 
            while($row_mod_id = mysqli_fetch_array($results_mod_id))
            {                                               

            $results_task_status = mysqli_query($conn,"SELECT * FROM tbl_task_status WHERE module_id='".$row_mod_id['id']."'");
            
                if(mysqli_num_rows($results_task_status) > 0)
                {
                    while($row_task_status = mysqli_fetch_array($results_task_status))
                    {
                        if($row_task_status['task_status'] == "Fully Done")
                        {
                            $c++;     
                            if($no_of_module == $c)
                            {      
                                $f = 1;  
                                mysqli_query($conn,"UPDATE tbl_todays_task SET 
                                task_status='Completed' WHERE task_id= '".$row['task_id']."'");
                            }

                        }
                    }
                }
            }

            if($f == 0)
            {
                mysqli_query($conn,"UPDATE tbl_todays_task SET 
                task_status='Incomplete' WHERE task_id= '".$row['task_id']."'");
            }
        }
?>
        <script type="text/javascript">
            window.location.href = 'emp_dashboard.php'; 
        </script>
<?php

    }


?>

 
<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Module List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Module List</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->

                <?php

                    $results = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$_GET['mod_id']."'"); 
                        $row = mysqli_fetch_array($results);
                        
                ?>
                <form method="post">
                    <section class="tasks">
                        <header class="tasks-header">
                          <h2 class="tasks-title"><?php echo $row['assignment_name'];?></h2>
                          <a href="index.html" class="tasks-lists">Lists</a>
                        </header>
                        <fieldset class="tasks-list">
                            <?php 
                                $results = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$_GET['mod_id']."'"); 
                                while($row = mysqli_fetch_array($results))
                                {
                                    extract($row);
                            ?>
                                    <label class="tasks-list-item" onclick="add_sel_status(<?php echo $row['id']?>)">
                                        <?php 
                                            $results_task_status = mysqli_query($conn,"SELECT * FROM tbl_task_status WHERE module_id='".$row['id']."'"); 
                                            if(mysqli_num_rows($results_task_status) > 0)
                                            {
                                                while($row_task_status = mysqli_fetch_array($results_task_status))
                                                {
                                                    if($row_task_status['task_status'] == "Fully Done")
                                                    {
                                        ?>
                                                        <input type="checkbox" name="task_1" value="1" class="tasks-list-cb" checked="">
                                                        <span class="tasks-list-mark"></span>
                                                        <span class="tasks-list-desc"><?php echo $row['module_name'];?></span>
                                                        <span id="sel_status_span<?php echo $row['id']?>"><br>
                                                            <select class="form-control"  onchange="add_pending_task(<?php echo $row['id']?>);" id="sel_status<?php echo $row['id']?>" name="sel_status<?php echo $row['id']?>">
                                                                    <option value="Fully Done">Fully Done</option>
                                                                    <option value="Partially Done">Partially Done</option>
                                                            </select>
                                                        </span>

                                                         <span style="display: none;" id="pending_work_span<?php echo $row['id']?>"><br>
                                                            <input class="form-control" type="text" name="pending_work<?php echo $row['id']?>" id="pending_work<?php echo $row['id']?>" placeholder="Add Pending Work">
                                                        </span>
                                        <?php
                                                    }else if($row_task_status['task_status'] == "Partially Done")
                                                    {
                                        ?>
                                                        <input type="checkbox" name="task_1" value="1" class="tasks-list-cb">
                                                        <span class="tasks-list-mark"></span>
                                                        <span class="tasks-list-desc"><?php echo $row['module_name'];?></span>
                                                        <span id="sel_status_span<?php echo $row['id']?>"><br>
                                                            <select class="form-control"  onchange="add_pending_task(<?php echo $row['id']?>);" id="sel_status<?php echo $row['id']?>" name="sel_status<?php echo $row['id']?>">  
                                                                    <option value="Partially Done">Partially Done</option>
                                                                    <option value="Fully Done">Fully Done</option>
                                                            </select>
                                                        </span>

                                                        <span id="pending_work_span<?php echo $row['id']?>"><br>
                                                            <input class="form-control" type="text" name="pending_work<?php echo $row['id']?>" id="pending_work<?php echo $row['id']?>" placeholder="Add Pending Work" value="<?php echo $row_task_status['pending_work'];?>">
                                                        </span>
                                        <?php
                                                    }else{
                                        ?>
                                                <input type="checkbox" name="task_1" value="1" class="tasks-list-cb">
                                                <span class="tasks-list-mark"></span>
                                                <span class="tasks-list-desc"><?php echo $row['module_name'];?></span>
                                                
                                                <span style="display: none;" id="sel_status_span<?php echo $row['id']?>"><br>
                                                    <select class="form-control"  onchange="add_pending_task(<?php echo $row['id']?>);" id="sel_status<?php echo $row['id']?>" name="sel_status<?php echo $row['id']?>">
                                                            <option value="0">Task Status</option>
                                                            <option value="Fully Done">Fully Done</option>
                                                            <option value="Partially Done">Partially Done</option>
                                                    </select>
                                                </span>
                                                
                                                <span style="display: none;" id="pending_work_span<?php echo $row['id']?>"><br>
                                                    <input class="form-control" type="text" name="pending_work<?php echo $row['id']?>" id="pending_work<?php echo $row['id']?>" placeholder="Add Pending Work">
                                                </span>

                                        <?php

                                                    }
                                                }
                                            }else{
                                        ?>

                                        <input type="checkbox" name="task_1" value="1" class="tasks-list-cb">
                                        <span class="tasks-list-mark"></span>
                                        <span class="tasks-list-desc"><?php echo $row['module_name'];?></span>
                                        
                                        <span style="display: none;" id="sel_status_span<?php echo $row['id']?>"><br>
                                            <select class="form-control"  onchange="add_pending_task(<?php echo $row['id']?>);" id="sel_status<?php echo $row['id']?>" name="sel_status<?php echo $row['id']?>">
                                                    <option value="0">Task Status</option>
                                                    <option value="Fully Done">Fully Done</option>
                                                    <option value="Partially Done">Partially Done</option>
                                            </select>
                                        </span>
                                        
                                        <span style="display: none;" id="pending_work_span<?php echo $row['id']?>"><br>
                                            <input class="form-control" type="text" name="pending_work<?php echo $row['id']?>" id="pending_work<?php echo $row['id']?>" placeholder="Add Pending Work">
                                        </span>
                                        <?php
                                            }
                                        ?>
                                    </label>
                                    
                            <?php 
                                }
                            ?>
                        </fieldset>
                    </section>
                    <div class="form-group row" style="margin-left: 47%;">
                        <button type="submit" class="btn btn-primary" name="btn_save">Save</button>                        
                    </div>
                </form>
                
                     
            </div>
            <!-- End Container fluid  -->
         </div>
          
			<?php include("footer.php"); ?>

<script type="text/javascript">
    function add_sel_status(id)
    {
        document.getElementById('sel_status_span'+id).style.display = "block";
    }

    function add_pending_task(id)
    {
        if(document.getElementById('sel_status'+id).value == "Partially Done")
        {
            document.getElementById('pending_work_span'+id).style.display = "block";
        }else 
        {
            document.getElementById('pending_work_span'+id).style.display = "none";
            document.getElementById('pending_work'+id).value = "";
        }
    }
</script>
			
