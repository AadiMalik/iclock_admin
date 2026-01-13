<?php
    include("connect.php");
    $id=$_GET['task_id'];
    if(isset($_POST['btn_update']))
    {
        
        if(!empty($_POST['txt']))
        {
            mysqli_query($conn,"DELETE FROM assign_task_module WHERE task_id = '".$_POST['task_id']."'");
            foreach($_POST['txt'] as $module)
            {                
                mysqli_query($conn,"INSERT INTO assign_task_module(task_id, assignment_name, module_name, status) VALUES ('".$_POST['task_id']."','".$_POST['assgn_name']."', '".$module."', '0')");

            }
        }


        $updated = mysqli_query($conn,"UPDATE tbl_task SET 
                assign_name='".$_POST['assgn_name']."',description='".$_POST['desc']."',start_date='".$_POST['start_date']."',end_date = '".$_POST['end_date']."' WHERE id= '$id'");
     
        if($updated)
        {
           header("Location:task_list.php");
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
                    <h3 class="text-primary">Update Assign Task</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Update Assign Task</li>
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
                                        $result = mysqli_query($conn,"SELECT * FROM tbl_task WHERE id='".$_GET['task_id']."'");
                                        //print_r($result);
                                        $row= mysqli_fetch_array($result);
                                        
                                        
                                  ?>  

                                <div class="form-validation">
                                    <form class="form-valide"  method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Task ID </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"  name="tid" disabled="" value="<?php echo $row['id']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Assignment Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="assgn_name" value="<?php echo $row['assign_name']; ?>" required>
                                            </div>
                                        </div>										

                                        <input type="hidden" name="task_id" value="<?php echo $row['task_id'];?>">
                                        <div class="form-group row control-group after-add-more">
                                            <label class="col-lg-4 col-form-label" for="val-address">Module Details </label>
                                            <div class="col-lg-6">
                                                <?php 
                                                    $result_modules = mysqli_query($conn,"SELECT * FROM assign_task_module WHERE task_id='".$row['task_id']."'");
                                                    while($row_modules = mysqli_fetch_array($result_modules))
                                                    {
                                                ?>
                                                        <input type="text" class="form-control" name="txt[]" value="<?php echo $row_modules['module_name']; ?>"><br>
                                                <?php 
                                                    }
                                                ?>            
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
                                                <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
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