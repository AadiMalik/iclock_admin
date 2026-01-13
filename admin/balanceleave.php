<?php   include('connect.php');
	  include("header.php");
      include("sidebar.php");
?>


<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> Employee Balance Leave</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Employee Balance Leave</li>
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
                                    <form class="form-valide" method="post">
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
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="show_record">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                
								<a href="addleave.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                <center>
                <table class="col-lg-4" border="1" width="100%">
                  <tr align="center">
                    <th colspan="2">Ideal Leaves</th>                    
                  </tr>
                    <?php 
                    $sql = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0";
                       $result = $conn->query($sql);
                    while($row=mysqli_fetch_array($result)){ ?>
                      <tr align="center">
                      <th ><?php echo $row['name']; ?></th>
                      <th><?php echo $row['no_of_days']; ?></th>
                      </tr>
                    <?php } ?>
                </table>
                </center>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Department Name</th>
                                              <th>Employee ID</th>
                                              <th>Photo</th>
                                              <th>Name</th>
                                              <th>Alloted Leave</th>
                                              <th>Sick Alloted Leave</th>
                                              <th>Taken Leave</th>
                                              <th> Sick Taken Leave</th>
                                              <?php 
                                                 $sql = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0";
                                                 $result = $conn->query($sql);
                                              while($row=mysqli_fetch_array($result)){ ?>
                                                <th><?php echo $row['name']; ?> Taken Leave</th>
                                              <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										include('connect.php');
                                        if(isset($_POST['show_record']))
                                        {
                                          if($_POST['dept']=='all')
                                          {
                                            $sql = "SELECT *, employees.eid AS empid FROM employees WHERE employees.admin_id='".$_SESSION['id']."'";
                                          }
                                          else
                                          {
                                            $sql = "SELECT *, employees.eid AS empid FROM employees WHERE employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."'";
                                          }

                                        }
                                        else
                                        {
                                          $sql = "SELECT *, employees.eid AS empid FROM employees WHERE employees.admin_id='".$_SESSION['id']."'";
                                        }
										
										$result = $conn->query($sql);
								// 		print_r($_row);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
											
										 $id = $row['eid'];
										 $emp_id = $row['employee_id'];
										 $emp_photo = $row['image'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
										 $alleave =  $row['allot_leave'];
										 $avleave =  $row['avail_leave'];
                                         $sick_allot_leave =  $row['sick_allot_leave'];
                                         $sick_avail_leave =  $row['sick_avail_leave'];
										 
											//print_r($row);
											
										$sql1 = "SELECT *, sum(leavetype) AS tleave FROM emp_leave WHERE employee = '$emp_id' ";
										$result1 = $conn->query($sql1);
										while($rows=mysqli_fetch_array($result1)){
											$dsql = "SELECT * FROM department WHERE id = '".$row['department_id']."'";
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
                
                                        $asql = "SELECT * FROM admin WHERE id = '".$row['admin_id']."'";
                                        $aquery = $conn->query($asql);
                                        $arow = $aquery->fetch_assoc();
									    ?>
										
                                            <tr>
                                                <td><?php echo $department_name; ?></td>
                                                <td><?php echo $emp_id; ?></td>
                                                <td><img src="<?php echo (!empty($row['image']))? 'uploaded/employee/'.$row['image']:'uploaded/profile.jpg'; ?>" width="30px" height="30px"> </td>
                                                <td><?php echo $emp_fname."  ".$emp_lname; ?></td>  
                                                <td><?php echo $alleave; ?></td>
                                                <td><?php echo $sick_allot_leave; ?></td>            
                                                <td align="center"><?php echo $rows['tleave']; ?></td>
                                                <td align="center"><?php echo $sick_allot_leave-$sick_avail_leave; ?></td>
											                         <?php 
                                                $sqlle = "SELECT * FROM leave_type WHERE admin_id='".$_SESSION['id']."' AND delete_status=0";
                                                 $resultle = $conn->query($sqlle);
                                              while($row=mysqli_fetch_array($resultle)){
                                                 $sql3 = "SELECT count(*) as cnt FROM attendance WHERE employee_id='".$id."' AND YEAR(date)='".date('Y')."' AND daytype='".$row['name']."'";
                                                 $result3 = $conn->query($sql3);
                                                 $row3=mysqli_fetch_assoc($result3)
                                               ?>
                                                <td><?php echo $row3['cnt']; ?></td>
                                              <?php } ?>
                                            </tr>
                                        <?php } }?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						</div>
						</div>
						</div>
			<?php include("footer.php"); ?>
			
