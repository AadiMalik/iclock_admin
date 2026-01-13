<?php 
	  include('connect.php');
	  include("header.php");
    include("sidebar.php");
?>
<?php
  include '../timezone.php';
  $range_to = date('m/d/Y');
  $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Payroll</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Payroll</li>
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
                                    <form class="form-valide" method="post" id="payForm">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Select Department</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="dept">
                                                  <option value="all">All</option>
                                                  <?php 
                          $sql = "SELECT * FROM department where delete_status=0 AND admin_id='".$_SESSION['id']."'";
                          $result = $conn->query($sql);
                          while($row=mysqli_fetch_array($result)){ ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['department_name'] ?></option>
                          <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-username">Select Duration</label>
                                            <div class="col-lg-6">
                                              <input type="text" id="reservation" class="form-control" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
                 </div>
               </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                              <button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span class="fa fa-print" ></span> Payroll</button>
                
                                              <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span class="fa fa-print"></span> Payslip</button>
                                                <button type="submit" class="btn btn-primary btn-sm btn-flat" name="show_record">Show</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                            <div class="pull-right">
							<!-- <form method="POST" class="form-inline" id="payForm">
							  <div class="form-group row">
								
								 <i class="fa fa-calendar"></i>						
								
								<input type="text" id="reservation" class="form-control pull-right col-sm-6" style="margin-right:20px;"  name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">&nbsp;
							<button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span class="fa fa-print" ></span> Payroll</button>
							  
							  <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span class="fa fa-print"></span> Payslip</button>
							   </div>
							   <br>
							   
							</form> -->
							<br>
						    </div>
								
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Department Name</th>
											      <th>Employee Name</th>
												  <th>Employee ID</th>
												  <th>Gross</th>
												  <th>Deductions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Department Name</th>
                                                  <th>Employee Name</th>
												  <th>Employee ID</th>
												  <th>Gross</th>
												  <th>Deductions</th>
												  
                                            </tr>
                                        </tfoot>
                    <tbody>
					<?php
                    
  
                    
                    $to = date('Y-m-d');
                    $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

                    if(isset($_POST['range'])){
                      $range = $_POST['range'];
                      $ex = explode(' - ', $range);
                      $from = date('Y-m-d', strtotime($ex[0]));
                      $to = date('Y-m-d', strtotime($ex[1]));
                    }
                    if(isset($_POST['show_record']))
                    {
                      if($_POST['dept']=='all')
                      {
                        $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, num_hr as nh FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";
                      }
                      else
                      {
                        $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, num_hr as nh FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC"; 
                      }

                    }
                    else
                    {
                      $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, num_hr as nh FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";
                    }
					
                    

					
					
                    $query = $conn->query($sql);
                    $total = 0;
					
                    while($row = $query->fetch_array()){
                      $empid = $row['empid'];
					  $e = $row['employee_id'];
					  $hr = $row['nh'];
                      
					  $status = $row['status'];
					  
					  
					    $rtsql = "SELECT *,rate FROM employees WHERE eid='$empid'";
						$rtquery = $conn->query($rtsql);
					    $rrow = $rtquery->fetch_array();
						
				        $rt = $rrow['rate'];

                $dsql = "SELECT * FROM department WHERE id = '".$rrow['department_id']."'";
                      $dquery = $conn->query($dsql);
                      $drow = $dquery->fetch_assoc();
                      if(!empty($drow))
                      {
                        $department_name = $drow['department_name'];
                      }
                      else
                      {
                        $department_name ='';
                      }
						
						$csql = "SELECT SUM(status) as st, num_hr FROM attendance WHERE employee_id='$empid' AND daytype <> 'LWP' AND date BETWEEN '$from' AND '$to'";
						$cquery = $conn->query($csql);
						$crow = $cquery->fetch_array();
						
					    
						$st = $crow['st'];
					    $hr = $crow['num_hr']; 
						
						$sal = $rt * $st;
					  
					 
					 $sd = "SELECT *, SUM(amount) as td FROM deductions WHERE empid='$e' AND date BETWEEN '$from' AND '$to'";
                     $queryd = $conn->query($sd);
                     $drow = $queryd->fetch_assoc();
                     $deduction = $drow['td'];
					 
                     
                      $gross = $sal;

                      echo "
                        <tr>
                        <td>".$department_name."</td>
                          <td>".$row['lastname']."  ".$row['firstname']."</td>
                          <td>".$row['employee_id']."</td>
                          <td>".number_format($gross, 2)."</td>
						  <td>".number_format($deduction, 2)."</td>
                        </tr>
                      ";
						
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
<?php include 'scripts.php'; ?> 
<script>
$(function(){
  
 /* $("#reservation").on('change', function(){
    var range = encodeURI($(this).val());
    window.location = 'payroll.php?range='+range;
  });*/

  $('#payroll').click(function(e){
    e.preventDefault();
    $('#payForm').attr('action', 'payroll_generate.php');
    $('#payForm').submit();
  });

  $('#payslip').click(function(e){
    e.preventDefault();
    $('#payForm').attr('action', 'payslip_generate.php');
    $('#payForm').submit();
  });

});

</script>


