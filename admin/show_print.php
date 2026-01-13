<style>
	tbody tr td {
    font-family: 'Poppins', sans-serif;
    color: black;
}
b
{
	margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    line-height: 1.33em;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
#popup_print {
    color: #000;
    margin: 0 auto;
}
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var,b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}
p {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
   	line-height: 1.33em;
    color: #7E7E7E;
}
</style>
<?php
include 'connect.php';
session_start();

date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');

if(isset($_POST['id']))
	$sql_order = "SELECT *, employees.rate as rt, employees.eid AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid='".$_POST['id']."'";
                $res_order = $conn->query($sql_order);
                $row = mysqli_fetch_assoc($res_order);
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
         $sql1 = "SELECT department_name from department WHERE id='".$row['department_id']."'";
                    $result1 = $conn->query($sql1);
                    $row1=mysqli_fetch_assoc($result1);
                    
 //$qrcodetxt = 'ID:'.$id.',Admin ID:'.$admin_id.', NAME: '.$full_name.', Position: '.$position.', Company :'.$_SESSION['company'].', Department :'.$row1["department_name"].'';
  $qrcodetxt = 'NAME: '.$full_name.',ID:'.$emp_id;
   $sql_header_logo = "select * from manage_website"; 
 $result_header_logo = $conn->query($sql_header_logo);
 $row_header_logo = mysqli_fetch_array($result_header_logo);
?>
<div id="printSection" >
  <div class="col-md-12">
  <div class="text-center">
    <p style="text-align: center; ">
      <span style="color: rgba(0, 0, 0, 0.87); font-family: arial, sans-serif-light, sans-serif; font-size: 30px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">
      <b></b>
    </span><br>
  </p>
</div>
<div style="clear:both;">
  <div style="clear:both;"></div>
  <br><div style="border: 5px solid gray;padding: 10px;height: 204px;width: 323.52px;">
  <div style="clear:both;">
    <div style="clear:both;">
      <table class="table" cellspacing="0" border="0">
        <!--<thead>
          <tr><th>Service</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>
        </thead>-->
        <tbody>
            <tr>
            <td style="text-align:center; font-size: 10px;">COMPANY</td>
            <td style="text-align:right; font-size: 10px;"><?php echo $_SESSION['company']; ?></td>
          </tr>
          <tr>
            <td style="text-align:center; font-size: 10px;">NAME</td>
            <td style="text-align:right;font-size: 10px;"><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
          </tr>
          <tr>
            <td style="text-align:center;font-size: 10px;"><img src="<?php echo (!empty($row['image']))? 'uploaded/employee/'.$row['image']:'uploaded/profile.jpg'; ?>" style="width: 70px;"></td>
            <td style="text-align:center;font-size: 20px;">ID : <?php echo $row['employee_id']; ?><br>PIN : <?php echo $row['pin']; ?><br> <p style="text-align:center;font-size: 10px;"> YOUR ID AND PIN IS STRICTLY PERSONAL AND IS NOT TRANSFERABLE.</p><br>
            <img src="../images/<?php echo $row_header_logo['logo'];?>" alt="homepage" class="dark-logo" style="height: 4%;width: 20%;margin-left: 63%;margin-top: -15%;"/>
            </td>
            <!--<td style="text-align:right;font-size: 10px;"><?php print '<img style="width: 70px;" src="../qrcode/qr_img.php?d='.$qrcodetxt.'">'; ?></td>-->
          </tr>
          <tr>
              <td colspan="2" style="text-align:center;font-size: 10px;">If case lost call : 5 976 7898</td>
          </tr>
          
        </tbody>
      </table>

      <!--<div style="border-top:1px solid #000; padding-top:10px;"><div style="clear:both;">
      <div class="text-center" style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;margin-top:20px;">If case lost call : 5 976 7898</div>
      </div></div>--></div></div></div></div></div>
  <div class="modal-footer">
    <button class="btn btn-warning noprint" onclick="myFunction(this)" data-print="<?php echo $row['eid']; ?>" id="no_print1"><i class="fa fa-print"></i> Print</button>
    <a href="employeelist.php" class="btn btn-danger noprint" id="no_print">Cancel</a>
  </div>