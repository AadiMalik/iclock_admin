<?php      
    include('connect.php');
    include("header.php");
    include("sidebar.php");
?>


<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Employee Task Status</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Employee Task Status</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <a href="add_task_status.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>        
                                                <th>End Date</th>            
                                                <th>Employee Name</th>
                                                <th>Task Name</th>      
                                                <th>Start Date</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>End Date</th>
                                                <th>Employee Name</th>
                                                <th>Task Name</th>      
                                                <th>Start Date</th>  
                                                <th>Action</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <!-- Dispaly Deadline Task -->
                                        <?php
                                            $results = mysqli_query($conn,"SELECT * FROM tbl_task WHERE status = '0' && task_status='Incomplete'");


                                            while($row = mysqli_fetch_array($results))
                                            {  
                                                $results_emp = mysqli_query($conn,"SELECT * FROM employees WHERE status = '0' && eid = '".$row['eid']."'");
                                                $row_emp = mysqli_fetch_array($results_emp);
                                            
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['end_date']; ?></td>
                                                    <td><?php echo $row_emp['firstname']." ".$row_emp['lastname']; ?></td>
                                                    <td><?php echo $row['assign_name']; ?></td>
                                                    <td><?php echo $row['start_date']; ?></td>
                                                    
                                                   
                                                    <td>
                                                        <a href="show_module_list_to_Admin.php?mod_id=<?php echo $row['task_id'];?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-pencil"></i> Module Details</a>
                                                        
                                                    </td>
                                                </tr>
                                            <?php      
                                                }
                                            ?>

                                          
                                        <!-- Dispaly Todays Task -->
                                        <?php
                                            $results = mysqli_query($conn,"SELECT * FROM tbl_todays_task WHERE status = '0' && task_status='Incomplete'");

                                            while($row = mysqli_fetch_array($results))
                                            {
                                                    $results_emp = mysqli_query($conn,"SELECT * FROM employees WHERE status = '0' && eid = '".$row['eid']."'");
                                                    $row_emp = mysqli_fetch_array($results_emp);

                                        ?>
                                                <tr>
                                                    <td><?php echo $row['task_assign_date']; ?></td>
                                                    <td><?php echo $row_emp['firstname']." ".$row_emp['lastname']; ?></td>
                                                    <td><?php echo $row['assign_name']; ?></td>
                                                    <td><?php echo $row['task_assign_date']; ?></td>
                                                    
                                                   
                                                    <td>
                                                        <a href="show_module_list_to_Admin.php?mod_id=<?php echo $row['task_id'];?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-pencil"></i> Module Details</a>
                                                        
                                                    </td>
                                                </tr>
                                            <?php 
                                                
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php include("footer.php"); ?>
  
