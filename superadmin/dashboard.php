<?php 
	  include('../connect.php');
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
                    <a href="account.php" class="col-md-4">
                        <div class="card p-20" style="background-color: #22324A">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-users f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
									 <?php
										$sql = "SELECT * FROM admin where delete_status=0;";
										$query = $conn->query($sql);

										echo "".$query->num_rows."";
									  ?>
									
									</h2>
                                    <p class="m-b-0">Total Accounts</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="email_mng.php" class="col-md-4">
                        <div class="card p-20" style="background-color: #6F931D">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-cog f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
									 <?php
										echo "Email";
									  ?>
									
									</h2>
                                    <p class="m-b-0">Setting</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="manage_website.php" class="col-md-4">
                        <div class="card p-20" style="background-color: #9E3E36">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-cogs f-s-40"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white">
									Appearance
									</h2>
                                    <p class="m-b-0">Management</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                </div>
				
               
            </div>
            <!-- End Container fluid  -->

                
			<?php include("footer.php"); ?>
