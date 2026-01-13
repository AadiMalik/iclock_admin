<?php
include('../connect.php');
include("header.php");
include("sidebar.php");
?>
<link rel="stylesheet" href="../uses/css/popup_style.css">

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
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
										                          <th>Employee ID</th>
                                              <th>Name</th>
                                              <th>Position</th>
                                              <th>Schedule</th>
											                        <th>Allotted Leave</th>
                                              <th>Member Since</th>
                                              <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Employee ID</th>
                                              <th>Name</th>
                                              <th>Position</th>
                                              <th>Schedule</th>
                                              <th>Allotted Leave</th>
                                              <th>Member Since</th>
                                              <th>Tools</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										$sql = "SELECT *, employees.rate as rt, employees.eid AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.admin_id='".$_SESSION['admin_id']."' AND employees.isActive='0' AND employees.isActive='0' AND  employees.department_id='".$_SESSION['id']."'";
										$result = $conn->query($sql);
										while($row=mysqli_fetch_array($result)){
											
											extract($row);
										 $id = $row['eid'];
										 $emp_id = $row['employee_id'];
                                         $admin_id = $row['admin_id'];
										 $emp_photo = $row['image'];
										 $emp_fname = $row['firstname'];
										 $emp_lname = $row['lastname'];
                                         $full_name=$emp_fname.' '.$emp_lname;
										 $position =  $row['description'];
										 $rate =  $row['rt'];
										 $schedule = date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out'])) ;
										 $date = date('M d, Y', strtotime($row['created_on']));
										 $leave =  $row['allot_leave'];
									    ?>
										
                                            <tr>
                                                <td><?php echo $emp_id; ?></td>
                                                <td><?php echo $emp_fname." ".$emp_lname; ?></td>
                                                <td><?php echo $position; ?></td>
                                                <td><?php echo $schedule; ?></td>
												<td align="center"><?php echo $leave; ?></td>
                                                <td><?php echo $date; ?></td>
												<td>
												<a href='#' data-id="<?=$id?>" class="btn btn-primary btn-sm edit btn-flat" onclick="show_print(this);"><i class="fa fa-print"> Print</i></a>
												
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
