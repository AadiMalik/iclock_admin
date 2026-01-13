<?php 
//session_start();
       include("connect.php");
       if(isset($_GET['emp_id']))
       {
            $id=$_GET['emp_id'];
            if(isset($_POST['submit']))
            {
                $sql = mysqli_query($conn,"SELECT * FROM assign_task_module ORDER BY id DESC LIMIT 1");
                if(mysqli_num_rows($sql) > 0)
                {
                    $row = mysqli_fetch_array($sql);
                    if(!empty($_POST['txt']))
                    {
                        foreach($_POST['txt'] as $module)
                        {
                            $task_id = $row['id']+1;
                            mysqli_query($conn,"INSERT INTO assign_task_module(task_id, assignment_name, module_name, status) VALUES ('$task_id','".$_POST['assgn_name']."', '".$module."', '0')");
                        }
                    }


                }else{
                    if(!empty($_POST['txt']))
                    {
                        foreach($_POST['txt'] as $module)
                        {
                            mysqli_query($conn,"INSERT INTO assign_task_module(task_id, assignment_name, module_name, status) VALUES ('1','".$_POST['assgn_name']."', '".$module."', '0')");
                        }
                    }
                }

                $sql_last_task = mysqli_query($conn,"SELECT * FROM assign_task_module ORDER BY id DESC LIMIT 1");
                $row_last_task = mysqli_fetch_array($sql_last_task);

                $sql1 = mysqli_query($conn,"INSERT INTO tbl_task(assign_name, task_id ,description, start_date, end_date,eid,task_status,status) VALUES ('".$_POST['assgn_name']."', '".$row_last_task['task_id']."', '".$_POST['desc']."', '".$_POST['start_date']."', '".$_POST['end_date']."','$id','Incomplete','0')");

                if($sql1)
                {
?>
                    <script>
                        window.location="task_list.php";
                    </script>
<?php
                }
            }

           
        }

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
                    <h3 class="text-primary">Assign Task</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Assign Task</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Assignment Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="assgn_name"  required>
                                            </div>
                                        </div>
										
										<div class="form-group row control-group after-add-more">
                                            <label class="col-lg-4 col-form-label" for="val-address">Module Details </label>
                                            <div class="col-lg-6">
                                                 <input type="text" class="form-control" id="val-firstname" name="txt[]">            
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="col-sm-3">
                                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                                </div>           
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Description  </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="desc"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">Start date</label>
                                            <div class="col-lg-6">    
                                                <input type="date" class="form-control" name="start_date" value="<?php 
                                                date_default_timezone_set("Asia/Kolkata"); echo date('Y-m-d');
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">End date</label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" name="end_date">
                                            </div>
                                        </div>

                                        <!--  -->
                                      
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                            </div>
                                        </div>
                                    </form>

                                    <div class="copy hide">
                                        <div class="form-group control-group row">
                                            <label class="col-sm-4 control-label require" for="inputEmail3">
                                            </label>
                                            
                                            <div class="col-sm-6">
                                                <input type='text' name='txt[]' class='form-control' required>

                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                  </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
</div>
<?php include("footer.php"); ?>


<script type="text/javascript">
    $(document).ready(function()
    {
        $(".add-more").click(function()
        { 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });  

        $("body").on("click",".remove",function()
        { 
            $(this).parents(".control-group").remove();      
        }); 

    });
</script>

