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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="../uses/icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title><?=$row_header_logo['title']?></title>
    <!-- Bootstrap Core CSS -->
    <link href="../uses/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../uses/css/helper.css" rel="stylesheet">
    <link href="../uses/css/style.css" rel="stylesheet">

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

<body class="fix-header fix-sidebar" style="background-image: url('../images/<?=$row_header_logo['background_login_image']?>');
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
					

			
					
					
            <div class="login-content card" style="margin-top: 20px; opacity:0.5">
			              <!--  <div class="justify-content-center" align="center" >
                      <img src="images/<?php //echo $row_header_logo['login_logo'];?>" alt="homepage" class="dark-logo" style="height: 10%;width: 50%;"/> -->
							<!--<img src="images/img.png" style="width:100px;height:10px;">--><!-- br>
							  <font size="5" color="black"><p id="date"></p>
							  <p id="time" class="bold"></p></font>
							</div> -->
							<hr>
              <div class="login-form" >
                
                <h4><img src="../images/<?php echo $row_header_logo['login_logo'];?>" alt="homepage" class="dark-logo" style="height: 10%;width: 25%; margin-top:0; padding-top:0"/></h4>
                  <form id="attendance" >
                      <div class="form-group">
                          
                              <div >
                                  <select class="form-control" id="val-time" name="status">
                                      <option value="in">Time In</option>
                                      <option value="out">Time Out</option>
                                   
                                  </select>
                              </div>
                      </div>
                       <div class="form-group" >
                        <label>Time IN Date</label>  
                      <input type="date" class="form-control" id="timeInDate" name="timeInDate" >    
                      </div>
                       <div class="form-group timeInDateDiv" style='display:none'>
                        <label>Time Out Date</label>  
                      <input type="date" class="form-control" id="timeOutDate" name="timeOutDate" >    
                      </div>
                      <div class="form-group" >
                        <label>Timing</label>  
                      <input type="time" class="form-control" id="Time" name="Time" >    
                      </div>
                      <div class="form-group">
                        <label>Enter Employee ID</label>  
                      <input type="text" class="form-control" id="employee" name="employee" required>    
                      </div>
                      <div class="form-group" id="remark_div">
                        <label>Remark</label>  
                      <input type="text" class="form-control" id="remark" name="remark">    
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
          
              
            </div>
						</div>

                </div>
            </div>
        </div>
             
     
    </div>
    
    
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="../uses/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../uses/js/lib/bootstrap/js/popper.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../uses/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="../uses/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../uses/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../uses/js/custom.min.js"></script>
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
	
<?php include '../scripts.php' ?>

<script type="text/javascript">
$(function() {
  var interval = setInterval(function() {
    var momentNow = moment();
    $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));  
    $('#time').html(momentNow.format('hh:mm:ss A'));
  }, 100);
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
      url: '../getEmp.php',
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
      url: 'take_employee_attendance.php',
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
   
    
  });
    
});
</script>
</body>
</html>