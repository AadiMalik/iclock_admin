<?php 

	  include('connect.php');

	 include("header.php");

	 include("sidebar.php");

	 error_reporting(0);

?>





<!-- Page wrapper  -->

	   <div class="page-wrapper">

		   <!-- Bread crumb -->

		   <div class="row page-titles">

			   <div class="col-md-5 align-self-center">

				   <h3 class="text-primary">Attendance</h3> </div>

			   <div class="col-md-7 align-self-center">

				   <ol class="breadcrumb">

					   <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>

					   <li class="breadcrumb-item active"> Attendance</li>

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

								   <form class="form-valide" action="attendance.php" method="POST">

									   <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Select Department</label>

										   <div class="col-lg-6">

											   <select class="form-control"  id="dept-drop" name="dept">

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

									   <b id="first_name"></b> 

                                        <b id="last_name"></b> 

									   <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Select Employee</label>

										   <div class="col-lg-6">

                                           <select class="form-control" name="emp_name" id="emp_name">
                                                <option value="">Select Name</option>
                                                                                           <?php 
                                                                                           $esql="SELECT * FROM employees where admin_id='".$_SESSION['id']."'";
                                                                                            $eresult = $conn->query($esql);
                                                                                              while($erow=mysqli_fetch_array($eresult)){ ?>

													   <option value="<?php echo $erow['eid'] ?>"><?php echo $erow['firstname'] ?> <?php echo $erow['lastname'] ?></option>

												   <?php } ?>
                                               
                                           </select>

										   </div>

									   </div>

									   <div class="form-group row">

										   <label class="col-lg-4 col-form-label" for="val-username">Date Range</label>

										   <div class="col-lg-6">

											   <input type="text" id="reservation" class="form-control" name="date_range" required>

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

						       <form action="exportatt.php" method="post"> 

						       <input type="hidden" name="dept" value="<?=$_POST['dept'];?>">

						        <input type="hidden" name="emp_name" value="<?=$_POST['emp_name'];?>">

						         <input type="hidden" name="date_range" value="<?=$_POST['date_range'];?>">

						       <button type="submit" class="btn btn-primary" name="To_Excel"><i class="fa fa-download"></i> &nbsp;CSV</button></form>

							   <!-- <a href="addattendance.php" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a> -->

							   

							   <div class="table-responsive m-t-40">

								   <!--<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">-->

								   <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

									   <thead>

										   <tr>

												 <th>Date</th>

												 <th>Day</th>

												 <th>Department Name</th>

												 <th class="no-export">Employee ID</th>

												 <th>Name</th>

												 <th>Time In</th>

												 <th>Time In Remark</th>
                                                 <th class="no-export">Location In</th>
												 <th>Time Out</th>

												 <th>Time Out Remark</th>
                                                 <th class="no-export">Location Out</th>
												 <th>Hrs</th>
												  <th class="no-export">OT1.5</th>
												 <th class="no-export">OT2</th>

												 <th>Day Type</th>
                                                 
												 <th class="no-export">Tools</th>

										   </tr>

									   </thead>

									   <tfoot>

										   <tr>

											   <th>Date</th>

											   <th>Day</th>

											   <th>Department Name</th>

												 <th class="no-export">Employee ID</th>

												 <th>Name</th>

												 <th>Time In</th>

												 <th>Time In Remark</th>
                                                 <th class="no-export">Location In</th>
												 <th>Time Out</th>

												 <th>Time Out Remark</th>
                                                 <th class="no-export">Location Out</th>

												 <th>Hrs</th>
												 <th class="no-export">OT1.5</th>
												 <th class="no-export">OT2</th>

												 <th>Day Type</th>
												 <th class="no-export">Tools</th>

										   </tr>

									   </tfoot>

									   <tbody>

									   <?php 

									   include('connect.php');

									   $limit = 100;

  if (isset($_GET["page"])) {  

     $pn  = $_GET["page"];  

   }  

   else {  

     $pn=1;  

   } 



   



   $start_from = ($pn-1) * $limit;

									   

								   if(isset($_GET['show_date']))

									   {

											   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND attendance.date='".$_GET['show_date']."' ORDER BY attendance.date DESC, attendance.time_in DESC LIMIT $start_from, $limit";

									   }

									   else if(isset($_POST['show_record']))

									   {

										$employid = $_POST['emp_name'];

										$dpt=$_POST['dept'];

											 $range = $_POST['date_range'];

											 $ex = explode(' - ', $range);

										  $from = date('Y-m-d', strtotime($ex[0]));

											 $to = date('Y-m-d', strtotime($ex[1]));

										   if($_POST['emp_name'])

										   {

												   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.eid='$employid' ORDER BY attendance.date DESC";

										   }

										   else if($dpt!=='all'){

												$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' ORDER BY attendance.date DESC";

											 

											}

										   else

										   if($_POST['dept']=='all')

										   {

											   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC";

										}

										


									   }

									   else

									   {

										//$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE  employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";

									

										  $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND attendance.date<='".date('Y-m-d')."' ORDER BY attendance.date DESC, attendance.time_in DESC LIMIT $start_from, $limit";
//echo $sql;die;
									   }

    									   $result = $conn->query($sql);
    									  

    									   while($row=mysqli_fetch_array($result)){

    										   

    										   extract($row);
    										   
    										   

										   

										   

										$id = $row['eid'];

										$e=$row['empid'];

										$aid= $row['attid'];

								// 		$date = date('d/m/Y', strtotime($row['date']));
                                        $date = $row['date'];

										$emp_id = $row['employee_id'];

										$emp_fname = $row['firstname'];

										$emp_lname = $row['lastname'];

//										$timein = date('h:i A', strtotime($row['time_in']));
										$timein = $row['time_in'];
										$timeout=$row['time_out'];
//                                        if($row['time_out'] != '00:00:00'){
//                                            $timeout=date('h:i A', strtotime($row['time_out']));
//                                        }
										
										

										$daytype=$row['daytype'];

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



										   $hsql = "SELECT * FROM half_attendance WHERE date = '".$row['date']."' AND employee_id='".$row['eid']."' AND approve_status=1";

										   $hquery = $conn->query($hsql);

										   $hrow = $hquery->fetch_assoc();

										   if(!empty($hrow))

										   {

											   $half = '<span class="label label-danger pull-right">Absent in <br>'.date('h:i a', strtotime($hrow['time_in'])).' - '.date('h:i a', strtotime($hrow['time_out'])).'</span>';

										   }

										   else

										   {

											   $half ='';

										   }

										   

									   ?>

									   

										   <tr>

											   <td><?php echo $date; ?></td>
												 <td><?php 
                                                $dayname = $row['date'];
                                                 $dateObj = DateTime::createFromFormat('Y-m-d', $dayname);
                                                 $dayOfWeek = $dateObj->format('l');
                                                 echo $dayOfWeek;
												 ?></td> 
                                                
												<td><?php echo $department_name; ?></td>

											   <td><?php echo $emp_id; ?></td>

											   <td><?php echo $emp_fname." ".       $emp_lname; ?></td>

											   <td><?php echo $timein; ?></td>

											   <td><?php echo $row['time_in_remark']; ?></td>
											   <td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row['lat1']; ?>,<?php echo $row['lng1']; ?>" target="_blank"><?php echo $row['location']; ?></a></td>

											   <td><?php echo $timeout; ?></td>

												<td><?php echo $row['time_out_remarks']; ?></td>
												<td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row['lat2']; ?>,<?php echo $row['lng2']; ?>" target="_blank"><?php echo $row['location2']; ?></a></td>

											   <td><?php  $hrs= number_format((float)$row['num_hr'], 2, '.', '');  
											   echo $hrs;
											   ?>
											   
											   </td>
                                                <td>
                                                    <?php echo ($dayOfWeek!="Sunday") ? $hrs : " ";?>
                                                    
                                                </td>
                                                <td> <?php echo ($dayOfWeek=="Sunday") ? $hrs : "";?>
                                                    
                                                </td>
											   <td><?php echo $daytype.'<br>'.$half; ?></td>
											   <td>

											   <?php if($daytype!='LWP' && $daytype!='Leave' && $daytype!='Sick Leave'){ ?>

											   <a href="editattendance.php?id=<?=$aid?>" class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Edit</a>

											   <a href="deleteattendance.php?id=<?=$aid?>" class="btn btn-danger btn-sm delete btn-flat" onclick="return confirm('Are you sure you wish to delete this Record?');"><i class="fa fa-trash"></i> Delete</a>

										   <?php } ?>

											   

											   </td>
											   

										  



										  </tr>

									   <?php } ?>

									   </tbody>

								   </table>

							   </div>

							   <div class="col-sm-12 text-center top20">

            <?php 

echo "<ul class='pagination' style='float:right;'>";

echo "<li class='p-1'><a class='btn btn-primary' href='attendance.php?page=1' class='pagination_button'>First</a></li>"; 

if($pn!=1)

{

  echo "<li class='p-1'><a class='btn btn-primary' href='attendance.php?page=".($pn-1)."' class='pagination_button'>Previous</a></li>"; 

}



if(isset($_GET['show_date']))

{

	   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND attendance.date='".$_GET['show_date']."' ORDER BY attendance.date DESC, attendance.time_in DESC";

}

else if(isset($_POST['show_record']))

{

$employid = $_POST['emp_name'];

$dpt=$_POST['dept'];

	 $range = $_POST['date_range'];

	 $ex = explode(' - ', $range);

  $from = date('Y-m-d', strtotime($ex[0]));

	 $to = date('Y-m-d', strtotime($ex[1]));

   if($_POST['emp_name'])

   {

		   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.eid='$employid' ORDER BY attendance.date DESC, attendance.time_in DESC";

   }

   else if($dpt!=='all'){

		$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' ORDER BY attendance.date DESC, attendance.time_in DESC";

	 

	}

   else

   if($_POST['dept']=='all')

   {

	   $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE attendance.date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";

}





}

else

{

//$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE  employees.admin_id='".$_SESSION['id']."' ORDER BY attendance.date DESC, attendance.time_in DESC";



  $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid,attendance.status as attend_status FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id WHERE employees.admin_id='".$_SESSION['id']."' AND attendance.date<='".date('Y-m-d')."' ORDER BY attendance.date DESC, attendance.time_in DESC";

}

$result = $conn->query($sql);

$total_records=$result->num_rows;

        $total_pages = ceil($total_records / $limit); 

if($pn!=$total_pages)

{

  echo "<li class='p-1'><a class='btn btn-primary' href='attendance.php?page=".($pn+1)."' class='pagination_button'>Next</a></li>";

}



echo "<li class='p-1'><a class='btn btn-primary' href='attendance.php?page=".($total_pages)."' class='pagination_button'>Last</a></li>";

echo "</ul>"; 

      ?>

        </div>

						   </div>

					   </div>

					   

					   </div>

					   </div>

					   </div>

		   <?php include("footer.php"); ?>

		   <?php include 'scripts.php'; ?> 

           <script>

$(document).ready(function() {

                  

$('#dept-drop').on('change', function() {

var id = this.value;

$.ajax({

    

url: "getattend.php",

type: "POST",

data: {

id: id

},

cache: false,

success: function(result){

 $("#emp_name").html(result);

// $('#emp_name').html('<option value="">Select Emp Name</option>'); 

//alert(result);

}

});

});    

});

</script>
<script>
$(document).ready(function () {

    $('#example23').DataTable({
        destroy: true,
        dom: 'Bfrtip',
        buttons: [

            // ===== COPY =====
            {
                extend: 'copy',
                exportOptions: { columns: ':not(.no-export)' },
                customizeData: addSummary
            },

            // ===== CSV =====
            {
                extend: 'csv',
                exportOptions: { columns: ':not(.no-export)' },
                customizeData: addSummary
            },

            // ===== EXCEL =====
            {
                extend: 'excel',
                exportOptions: { columns: ':not(.no-export)' },
                customizeData: addSummary
            },

            // ===== PDF =====
            {
                extend: 'pdf',
                exportOptions: { columns: ':not(.no-export)' },
                customize: function (doc) {

                    let body = doc.content[1].table.body;
                    let nameIndex = 3; // ✅ NAME
                    let counts = {};
                    let total = 0;

                    // Count employee attendance
                    body.slice(1).forEach(row => {
                        let name = row[nameIndex].text || row[nameIndex];
                        if (name) {
                            counts[name] = (counts[name] || 0) + 1;
                            total++;
                        }
                    });

                    // 🔹 Extra blank row at top
                    body.unshift(Array(body[0].length).fill(''));

                    // 🔹 Heading row
                    let headingRow = Array(body[0].length).fill('');
                    headingRow[nameIndex] = { text: 'Employees Days Total', bold: true };
                    body.unshift(headingRow);

                    // Blank row after heading
                    body.splice(1, 0, Array(body[0].length).fill(''));

                    // Employee-wise summary rows
                    Object.keys(counts).forEach(name => {
                        let row = Array(body[0].length).fill('');
                        row[nameIndex] = { text: name, bold: true };
                        row[nameIndex + 1] = { text: counts[name], bold: true };
                        body.push(row);
                    });

                    // Total row
                    let totalRow = Array(body[0].length).fill('');
                    totalRow[nameIndex] = { text: 'Total', bold: true };
                    totalRow[nameIndex + 1] = { text: total, bold: true };
                    body.push(totalRow);
                }
            },

            // ===== PRINT =====
            {
                extend: 'print',
                exportOptions: { columns: ':not(.no-export)' },
                customize: function (win) {

                    let counts = {};
                    let total = 0;

                    $(win.document.body)
                        .find('table tbody tr')
                        .each(function () {
                            let name = $(this).find('td:eq(3)').text().trim();
                            if (name) {
                                counts[name] = (counts[name] || 0) + 1;
                                total++;
                            }
                        });

                    // 🔹 Heading + space
                    let html = '<tr><td colspan="100%">&nbsp;</td></tr>';
                    html += '<tr><td colspan="100%"><strong>Employees Days Total</strong></td></tr>';
                    html += '<tr><td colspan="100%">&nbsp;</td></tr>';

                    // Employee-wise summary
                    $.each(counts, function (name, count) {
                        html += `<tr><td colspan="3"><strong>${name}</strong></td><td>${count}</td></tr>`;
                    });

                    // Total row
                    html += `<tr><td colspan="3"><strong>Total</strong></td><td><strong>${total}</strong></td></tr>`;

                    $(win.document.body).find('table').append(html);
                }
            }
        ]
    });

    // ===== COMMON FUNCTION =====
    function addSummary(data) {

        let nameIndex = 3;
        let counts = {};
        let total = 0;

        // Count employee attendance
        data.body.forEach(row => {
            let name = row[nameIndex];
            if (name) {
                counts[name] = (counts[name] || 0) + 1;
                total++;
            }
        });

        // 🔹 Extra space at top
        data.body.push(Array(data.header.length).fill(''));

        // 🔹 Heading row
        let headingRow = Array(data.header.length).fill('');
        headingRow[nameIndex] = 'Employees Days Total';
        data.body.push(headingRow);

        // Empty row after heading
        data.body.push(Array(data.header.length).fill(''));

        // Employee-wise rows
        Object.keys(counts).forEach(name => {
            let row = Array(data.header.length).fill('');
            row[nameIndex] = name;
            row[nameIndex + 1] = counts[name];
            data.body.push(row);
        });

        // Total row
        let totalRow = Array(data.header.length).fill('');
        totalRow[nameIndex] = 'Total';
        totalRow[nameIndex + 1] = total;
        data.body.push(totalRow);
    }

});
</script>



		   

