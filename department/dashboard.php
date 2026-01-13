<?php  include('../connect.php');
	  include("header.php");
      include("sidebar.php");
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
                <div class="row">
                    <div class="col-md-4">
                        <a href="employeelist.php">
                        <div class="card p-20" style="background-color: #22324A">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-users f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
                                     <?php
                                        $sql = "SELECT * FROM employees WHERE isActive='0' AND department_id='".$_SESSION['id']."'";
                                        $query = $conn->query($sql);

                                        echo "".$query->num_rows."";
                                      ?>
                                    
                                    </h2>
                                    <p class="m-b-0">Total Employees</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-md-4">
                        <a href="attendance.php?show_date=<?=date('Y-m-d')?>">
                        <div class="card p-20" style="background-color: #6F931D">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-user f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
                                     <?php
                                        $today = date("Y/m/d");
                                        $sql = "SELECT * FROM attendance WHERE date = '$today' AND daytype NOT IN ('Leave','LWP') AND department_id='".$_SESSION['id']."'";
                                        $query = $conn->query($sql);

                                        echo "".$query->num_rows.""
                                      ?>
                                    
                                    </h2>
                                    <p class="m-b-0">Present On Today</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-md-4">
                        <a href="attendance.php?show_date=<?=date('Y-m-d')?>">
                        <div class="card p-20" style="background-color: #9E3E36">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-user f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
                                    <?php
                                        $sql = "SELECT * FROM attendance WHERE date = '$today' AND daytype NOT IN ('Regular','Holiday','Sunday') AND department_id='".$_SESSION['id']."'";
                                        $query = $conn->query($sql);

                                        echo "".$query->num_rows.""
                                      ?>
                                    </h2>
                                    <p class="m-b-0">On Leave Today</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    
                </div>
				
               
            </div>
            <!-- End Container fluid  -->

                
			<?php include("footer.php"); ?>
