<?php
    ob_start(); 
        include('connect.php');
        if(isset($_GET['id']))
       {
        $id=$_GET['id'];   
        if(isset($_POST['submit'])){
        $assign = $_POST['assgn_name'];
        $module = $_POST['module_details'];
        $desc = $_POST['desc'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        //$eid = $_POST['emp_name'];
        //$gender = $_POST['gender'];
        
        //creating employeeid
       
        $sql = "INSERT INTO  tbl_emergency(assignment_name, module_desc, description, start_date, end_date,eid) VALUES ('$assign', '$module', '$desc', '$start_date', '$end_date','$id')";
        $result= mysqli_query($conn,$sql);
        
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
                    <h3 class="text-primary">Add Emergency Task</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Add Emergency Task</li>
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
                                 <div class="form-validation">
                                    <form class="form-valide" method="post" >
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Assignment Name </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-firstname" name="assgn_name"  required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Module Details </label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="exampleTextarea" rows="3"  name="module_details"></textarea>
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
                                                <input type="date" class="form-control" name="start_date">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-date">End date</label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" name="end_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        
                        </div>
                        </div>
                        </div>
            <?php include("footer.php"); ?>
            
