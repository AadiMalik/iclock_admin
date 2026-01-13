<?php 
 session_start(); 
/*02d23*/



/*02d23*/

include('connect.php');
?>
<?php
 $sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
 <title>ICLOCK by IDA MAURIIUS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2></h2>
  <div class="btn-group">
    <button type="button" class="btn btn-primary">Iclock access</button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="https://iclock.mu/admin/admin/" >Admin Access</a>
      <a class="dropdown-item" href="https://iclock.mu/admin/department/">Department Access</a>
      <a class="dropdown-item" href="https://iclock.mu/admin/superadmin/">Team Access</a>
      
    </div> 
  </div>
  
  <div class="btn-group">
   <!--  <button type="button" class="btn btn-secondary">Daily Updates</button>
    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="http://idaworks.idamru.net/daily_sale/">Daily Sales</a>
     <a class="dropdown-item" href="http://ireserve.idamru.net/">Product Reservation</a>
      <a class="dropdown-item" href="http://repairs.idamru.net/">Repairs records</a>
      <a class="dropdown-item" href="http://battery.idamru.net/">Battery change records</a>
      <a class="dropdown-item" href="http://watchregistration.idamru.net/">Watch Sold Registrations</a>
       <a class="dropdown-item" href="https://ireserve.idamru.net"> Product reservation</a>
      <a class="dropdown-item" href="https://pos2.idamru.net/login">Access Point of Sales(POS)</a>
      <a class="dropdown-item" href="https://repair.idamru.net/login"> Watch Repairs System</a>
    </div>
  </div>

  <div class="btn-group">
    <button type="button" class="btn btn-danger">Your area</button>
    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
   <!--    <a class="dropdown-item" href="https://mikadoclients.idamru.net/">Add clients</a>-->
    </div>
  </div>

 <!-- 
 <a href="http://iclock.idamru.com/department/" class="btn btn-block btn-info" target="_blank">DEPARTMENT ACCESS</a>
              <a href="http://iclock.idamru.com/admin/" class="btn btn-block btn-info" target="_blank">ADMIN ACCESS</a>
              <a href="http://idaworks.idamru.com/daily_sale/" class="btn btn-block btn-info" target="_blank">DAILY SALES</a>
              <a href="http://ireserve.idamru.com/" class="btn btn-block btn-info" target="_blank">PRODUCT RESERVATION</a>
              <a href="http://repairs.idamru.com/" class="btn btn-block btn-info" target="_blank">REPAIRS RECORDS</a>
              <a href="http://battery.idamru.com/" class="btn btn-block btn-info" target="_blank">BATTERY CHANGE RECORDS</a> 
              <a href="http://mikadoclients.idamru.com/" class="btn btn-block btn-info" target="_blank">ADD CLIENT</a> 
              <a href="http://idasystem.idamru.com/" class="btn btn-block btn-info" target="_blank">IDA</a> 
 
 <div class="btn-group">
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">Link 1</a>
      <a class="dropdown-item" href="#">Link 2</a>
    </div>
  </div>

  <div class="btn-group">
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">Link 1</a>
      <a class="dropdown-item" href="#">Link 2</a>
    </div>
  </div>

  <div class="btn-group">
    <button type="button" class="btn btn-danger">Your area</button>
    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">Link 1</a>
      <a class="dropdown-item" href="#">Link 2</a>
    </div>-->
  </div>
</div>
  </div>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</body>
</body>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="uses/icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title><?=$row_header_logo['title']?></title>
    <!-- Bootstrap Core CSS -->
    <link href="uses/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="uses/css/helper.css" rel="stylesheet">
    <link href="uses/css/style.css" rel="stylesheet">

<style type="text/css">
  		.mt20{
  			margin-top:20px;
  		}
  		.result{
  			font-size:20px;
  		}
      .bold{
        font-weight: bold;
      }
</style>
<style>
.blue { background:#fff;}

.mynews {
    box-shadow: inset 0 -15px 30px rgba(0,0,0,0.4), 0 5px 10px rgba(0,0,0,0.5);
    margin: 20px auto;
    overflow: hidden;
    border-radius: 4px;
    padding: 1px;
    -webkit-user-select: none;
}

.mynews span {
  height: 40px;
    float: left;
    color: #000;
    padding: 9px;
    position: relative;
    top: 1%;
    box-shadow: inset 0 -15px 30px rgba(0,0,0,0.4);
    font: 16px 'Raleway', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -webkit-user-select: none;
    cursor: pointer;
    /*margin-bottom: 900px;*/
}

.text1{
box-shadow:none !important;
width: 90%;
}
@media only screen and (min-width: 300px) and (max-width: 576px) {
  .text1{
    width: 65%;
}
@media only screen and (min-width: 576px) and (max-width: 768px) {
  .text1{
    width: 72%;
}
@media only screen and (min-width: 768px) and (max-width: 992px) {
  .text1{
    width: 85%;
}
@media only screen and (min-width: 992px) and (max-width: 1200px) {
  .text1{
    width: 88%;
}
@media only screen and (min-width: 1200px) and (max-width: 1500px) {
  .text1{
    width: 89%;
}
}
</style>
</head>

<body class="fix-header fix-sidebar" style="background-image: url('images/<?=$row_header_logo['background_login_image']?>');
 background-repeat: no-repeat;background-size: cover;overflow: auto; ;">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    

	
	<div id="main-wrapper">
    <div class="mynews blue">
        <span style="background-color: #db0909;"><b> Warning </b></span>
        <span class="text1" >
          <marquee><b>
          <?php 
          $i=1;
          $sql = "SELECT * FROM news where delete_status=0 and status=0 order by id desc";
          $result = $conn->query($sql);
          while($row=mysqli_fetch_array($result)){
            ?>
            <?php echo $i.'.'.$row['details'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
            <?php $i++; } ?>
            </b></marquee>
          </span>
    </div>
        <div class="unix-login" >
		
			
            <div class="container-fluid">
			
			
                <div class="row justify-content-right">
				
				
                    <div class="col-lg-4" style="">
					

			
					
					
            <div class="login-content card" style="margin-top: 20px;opacity: 0.5;">
			              <!--  <div class="justify-content-center" align="center" >
                      <img src="images/<?php //echo $row_header_logo['login_logo'];?>" alt="homepage" class="dark-logo" style="height: 10%;width: 50%;"/> -->
							<!--<img src="images/img.png" style="width:100px;height:10px;">--><!-- br>
							  <font size="5" color="black"><p id="date"></p>
							  <p id="time" class="bold"></p></font>
							</div> -->
							<hr>
              <div class="login-form" >
                <?php 
                    $sql_header_logo = "select * from manage_website"; 
                     $result_header_logo = $conn->query($sql_header_logo);
                     $row_header_logo = mysqli_fetch_array($result_header_logo);

                 ?>
                <h4><img src="images/<?php echo $row_header_logo['login_logo'];?>" alt="homepage" class="dark-logo" style="height: 10%;width: 25%;"/></h4>
                  <form method="post" action='attendance_2.php' >
                      <div class="form-group">
                          
                              <div >
                                  <select class="form-control" id="val-time" name="status">
                                      <option value="in">Time In</option>
                                      <option value="out">Time Out</option>
                                     <!--- <option value="apply_leave">Apply For Leave</option>-->
                                      <option value="login">Login</option>
                                  </select>
                              </div>
                      </div>
                       <div class="form-group timeInDateDiv" style='display:none'>
                        <label>Time IN Date</label>  
                      <input type="date" class="form-control" id="timeInDate" name="timeInDate" >    
                      </div>
                      <div class="form-group">
                        <label>Enter Employee ID</label>  
                      <input type="text" class="form-control" id="employee" name="employee" required>    
                      </div>
                      <div class="form-group" id="remark_div">
                        <label>Remark</label>  
                      <input type="text" class="form-control" id="remark" name="remark">    
                      </div>
                      <div id="login_div" style="display: none;">
                        <div class="form-group row">
                            <label>Pin <span style="color: red;">*</span></label>
                            <div class="col-lg-12">
                                <input type="password" class="form-control"  name="passwd1">
                            </div>
                        </div>
                      </div>
                      <div id="apply_leave" style="display: none;">
                        <div class="form-group row">
                            <label>Pin <span style="color: red;">*</span></label>
                            <div class="col-lg-12">
                                <input type="password" class="form-control"  name="passwd">
                            </div>
                        </div>
                        <div class="form-group row">
                              <label>First Select Day Type <span style="color: red;">*</span></label>
                              <div class="col-lg-12 ">
                                  <select name="day" id="day" class="form-control custom-select">
                                     <option>--Select--</option>
                                     <option value="0.5">Half Day</option>
                                     <option value="1">Full Day</option>
                                  </select>
                              </div>
                          </div>
                          <div id="half_day" style="display: none;">
                            <div class="form-group row">
                                <label>Date <span style="color: red;">*</span></label>
                                <div class="col-lg-12">
                                    <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control"  name="date">
                                </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-form-label" for="val-daytype">Leave Type</label>
                              <div class="col-lg-12 ">
                                  <select name="half_leave_type" id="half_leave_type" class="form-control custom-select">
                                    <option value="">Enter Employee ID First</option>
                                    <?php 
                                      $sql = "SELECT * FROM leave_type WHERE delete_status=0";
                                    $result = $conn->query($sql);
                                  while($row=mysqli_fetch_array($result)){
                                    ?>
                                    <option class="option_leave" value="<?php echo $row['name']; ?>" style="display: none;" data-id="<?php echo $row['admin_id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                          </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="val-date">From Time</label>
                                <div class="col-lg-12">
                                    <input type="time" class="form-control"  name="time_in">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="val-date">To Time </label>
                                <div class="col-lg-12">
                                    <input type="time" class="form-control"  name="time_out">
                                </div>
                            </div>
                          </div>
                          <div id="full_day" style="display: none;">
                            <div class="form-group row">
                              <label class="col-form-label" for="val-daytype">Leave Type</label>
                              <div class="col-lg-12 ">
                                  <select name="leave_type" id="leave_type" class="form-control custom-select">
                                    <option value="">Enter Employee ID First</option>
                                     <?php 
                                      $sql = "SELECT * FROM leave_type WHERE delete_status=0";
                                    $result = $conn->query($sql);
                                  while($row=mysqli_fetch_array($result)){
                                    ?>
                                    <option class="option_leave" value="<?php echo $row['name']; ?>" style="display: none;" data-id="<?php echo $row['admin_id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                          </div>
                            <div class="form-group row">
                                <label for="val-date">From Date <span style="color: red;">*</span></label>
                                <div class="col-lg-12">
                                    <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control"  name="from_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label>To Date <span style="color: red;">*</span></label>
                                <div class="col-lg-12">
                                    <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control"  name="to_date">
                                </div>
                            </div>
                          </div>
                          <div class="form-group row">
                              <label >Reason <span style="color: red;">*</span></label>
                              <div class="col-lg-12">
                                  <input type="text" class="form-control"  name="reason">
                              </div>
                          </div>
                      </div>
                      
                      <button type="submit" class="btn btn-danger btn-flat m-b-30 m-t-30" name="signin" ><i class="fa fa-sign-in"></i> Submit</button>
                      
                  </form>
              </div>
              <div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
              </div>
              <div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
              </div>
           <!--   <a href="http://iclock.idamru.com/department/" class="btn btn-block btn-info" target="_blank">DEPARTMENT ACCESS</a>
              <a href="http://iclock.idamru.com/admin/" class="btn btn-block btn-info" target="_blank">ADMIN ACCESS</a>
              <a href="http://idaworks.idamru.com/daily_sale/" class="btn btn-block btn-info" target="_blank">DAILY SALES</a>
              <a href="http://ireserve.idamru.com/" class="btn btn-block btn-info" target="_blank">PRODUCT RESERVATION</a>
              <a href="http://repairs.idamru.com/" class="btn btn-block btn-info" target="_blank">REPAIRS RECORDS</a>
              <a href="http://battery.idamru.com/" class="btn btn-block btn-info" target="_blank">BATTERY CHANGE RECORDS</a> 
              <a href="http://mikadoclients.idamru.com/" class="btn btn-block btn-info" target="_blank">ADD CLIENT</a> 
              <a href="http://idasystem.idamru.com/" class="btn btn-block btn-info" target="_blank">IDA</a> -->
              
            </div>
						</div>

                </div>
            </div>
        </div>
             
     
    </div>
    
    
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="uses/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="uses/js/lib/bootstrap/js/popper.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="uses/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="uses/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="uses/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="uses/js/custom.min.js"></script>
<script>
    $("#val-time").change(function(){
  timevalue=$(this).val();
  if(timevalue=="out")
  {
  
      //timeInDate
    $(".timeInDateDiv").show();  
  }
  else{
    
    $(".timeInDateDiv").hide();  
  }
   
});
</script>
	
<?php include 'scripts.php' ?>

<script type="text/javascript">
$(function() {
//   var interval = setInterval(function() {
//     var momentNow = moment();
//     $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));  
//     $('#time').html(momentNow.format('hh:mm:ss A'));
//   }, 100);
  $('#val-time').change(function() {
    var select=$('#val-time').val();
    if(select=='apply_leave')
    {
      $('#apply_leave').show();
      $('#login_div').hide();
      $('#remark_div').hide();
    }
    else if(select=='login')
    {
      $('#login_div').show();
      $('#apply_leave').hide();
      $('#remark_div').hide();
    }
    else
    {
      $('#remark_div').show();
      $('#apply_leave').hide();
      $('#login_div').hide();
    }
  })
  $('#day').change(function() {
          var day=$('#day').val();
          if(day==0.5)
          {
            $('#half_day').show();
            $('#full_day').hide();
          }
          else
            {
            $('#half_day').hide();
            $('#full_day').show();
          }
        });
   $('#employee').blur(function() {
    $.ajax({
      type: 'POST',
      url: 'getEmp.php',
      data: { emp_id:$('#employee').val()},
      dataType: 'json',
      success: function(response){
        console.log(response);
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $("#leave_type").children('option .option_leave').hide();
          var admin_id=response.admin_id;
          $("#leave_type").children("option[data-id="+admin_id+ "]").show();

          $("#half_leave_type").children('option .option_leave').hide();
          var admin_id=response.admin_id;
          $("#half_leave_type").children("option[data-id="+admin_id+ "]").show();
        }
      }
      });
   });
  $('#attendance').submit(function(e){
    e.preventDefault();
    var attendance = $(this).serialize();
    if($('#val-time').val()=='in' || $('#val-time').val()=='out')
    {
      $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        console.log(response);
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#employee').val('');
        }
      }
      });
    }
    else if($('#val-time').val()=='apply_leave')
    {
      $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        console.log(response);
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#employee').val('');
        }
      }
      });
      setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);
    }
    else if($('#val-time').val()=='login')
    {
      $.ajax({
      type: 'POST',
      url: 'employee/index.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        console.log(response);
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          setTimeout(function(){// wait for 5 secs(2)
                   window.location='employee/dashboard.php';// then reload the page.(3)
              }, 1000);
          
        }
      }
      });
    }
    
  });
    
});
</script>
</body>
</html>