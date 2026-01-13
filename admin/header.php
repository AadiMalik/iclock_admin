<?php session_start();
include('../connect.php');
if(basename($_SERVER["SCRIPT_FILENAME"]) != 'register.php'){
if(!isset($_SESSION["id"]))
{
    header('location:index.php');    
}
}
// print_r($_SESSION["id"]);
?>
<?php

 $sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title><?=$row_header_logo['title']?> </title>

    <link href="../uses/css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="../uses/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    
    <link href="../uses/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="../uses/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="../uses/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="../uses/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../uses/css/helper.css" rel="stylesheet">
    <link href="../uses/css/new_style.css" rel="stylesheet">
    
     <link href="../uses/css/sticky.css" rel="stylesheet">
     <link href="../uses/css/sticky_2nd.css" rel="stylesheet">
  
   <link rel="stylesheet" href="../uses/bower_components/bootstrap-daterangepicker/daterangepicker.css"> 
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../uses/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="../uses/plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../uses/css/lib/select2/select2.min.css">
    
    </head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <!--<div class="preloader">-->
    <!--    <svg class="circular" viewBox="25 25 50 50">-->
    <!--        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>-->
    <!--</div>-->
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="">
                        <!-- Logo icon -->
                        <b><img src="../images/<?php echo $row_header_logo['logo'];?>" alt="homepage" class="dark-logo" style="width: 10%;"/></b>                        <!--End Logo icon -->
                       <!-- Logo text -->
                        
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- Messages -->
                       
                            
                        
                    </ul>
                    <!-- User profile  -->
                    <ul class="navbar-nav my-lg-0">

                        
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo($_SESSION["image"]!=NULL)?'<img  width="30" src="uploaded/'.$_SESSION["image"].'"  >' :'' ;?>
                            &nbsp;
                            <?php echo $_SESSION["fname"]." ".$_SESSION["lname"];  ?>
                            
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="editprofile.php?id=<?php echo $_SESSION["id"]; ?>"><i class="ti-user"></i> Profile</a></li>
                                   
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
  
        