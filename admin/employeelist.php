<?php
include('connect.php');
include("header.php");
include("sidebar.php");
?>
<link rel="stylesheet" href="popup_style.css">

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Employee List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Employee List</li>
                    </ol>
                </div>
            </div>
             <?php
            if(isset($_SESSION['data']))
            {
                echo $_SESSION['data'];
                unset($_SESSION['data']);
            }
            ?>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                      <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='danger') { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Something Goes Wrong. ID s are not inserted Properly.
                            </div>
                        <?php unset($_SESSION["reply"]); } ?> 
                        <?php if(isset($_SESSION['reply']) && $_SESSION['reply']=='success') { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               Operation Performed Successfully.
                            </div>
                        <?php unset($_SESSION["reply"]); } ?>
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
                       echo   $sql = "SELECT * FROM department where delete_status=0 AND admin_id='".$_SESSION['id']."'";
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
                              <a href="addemployee.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								              <a href="import.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> Import CSV</a>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Department Name</th>
										                          <th>Employee ID</th>
                                              <th>Name</th>
                                              <th>Position</th>
                                              <th>Phone</th>
											                        <th>Allotted Leave</th>
                                              <th>Member Since</th>
                                              <th>Active Status</th>
                                              <th>Tools</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
										<?php 
										include('connect.php');
                    if(isset($_POST['show_record']))
                    {
                      if($_POST['dept']=='all')
                      {
                        $sql = "SELECT *, employees.rate as rt, employees.eid AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.admin_id='".$_SESSION['id']."'";
                      }
                      else
                      {
                        $sql = "SELECT *, employees.rate as rt, employees.eid AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."'";
                      }

                    }
                    else
                    {
                      $sql = "SELECT *, employees.rate as rt, employees.eid AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.admin_id='".$_SESSION['id']."'";
                    }
										
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
										 $id = $row['eid'];
										 $emp_id = $row['employee_id'];
										  $emp_isAtive = $row['isActive'];
										  if($emp_isAtive==0)
										  {
										      $ativeStatus="<span class='badge badge-info'>Active</span>";
										  }
										  elseif($emp_isAtive==1)
										  {
										       $ativeStatus="<span class='badge badge-warning'>In-Active</span>";
										  }
										  else{
										      $ativeStatus="";
										  }
                                         $admin_id = $row['admin_id'];
										 $emp_photo = $row['image'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
                                         $full_name=$emp_fname.' '.$emp_lname;
										 $position =  $row['description'];
										 $rate =  $row['rt'];
										 $phone =  $row['contact_info'];
										 $date = date('d/m/Y', strtotime($row['created_on']));
										 $leave =  $row['allot_leave'];

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

									    ?>
										
                                            <tr>
                                              <td><?php echo $department_name; ?></td>
                                                <td><?php echo $emp_id; ?></td>
                                                <td><?php echo $emp_fname." ".$emp_lname; ?></td>
                                                <td><?php echo $position; ?></td>
                                                <td><?php echo $phone; ?></td>
												<td align="center"><?php echo $leave; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td>
                                                    <?= $ativeStatus;?>
                                                </td>
												<td>
                          <a href="sendemail.php?id=<?=$id?>" class="btn btn-warning btn-sm edit btn-flat"><i class="fa fa-send"></i> Send</a>
												<a href='#' data-id="<?=$id?>" class="btn btn-primary btn-sm edit btn-flat" onclick="show_print(this);"><i class="fa fa-print"> Print</i></a>
												<a href="editemployee.php?id=<?=$id?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="deleteemp.php?id=<?=$id?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>
												
												</td>
                                           

										   </tr>
                                        <?php } ?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						</div>
						</div>
						</div>
						<div class="popup" id="popup_print">
                       <div class="popup__background"></div>
                         <div class="popup__content" style="text-align: initial !important;width: 43%;">
                            <h3 class="popup__content__title">
                            </h3>
                            <div id="show_print"></div>
                          </div>
                         </div>
			<?php include("footer.php"); ?>
			<script>
			    function show_print(elem)
 {
     var id1=$(elem).attr('data-id');
   $.ajax({
               type:'POST',
               url:'show_print.php',
              data:{id:id1},
               success:function(html){
               // alert(html);
                $('#show_print').html(html);
                  
               }
           });
   $('#popup_print').addClass('popup--visible');
 }
			</script>
			<script>
 function myFunction(element) 
{
  var printButton = document.getElementById("no_print");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        var printButton1 = document.getElementById("no_print1");
        //Set the print button visibility to 'hidden' 
        printButton1.style.visibility = 'hidden';
  var divToPrint=document.getElementById('popup_print');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},5);
printButton.style.visibility = 'visible';
printButton1.style.visibility = 'visible';
}
 </script>
