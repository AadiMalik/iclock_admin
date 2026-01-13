<?php
session_start();
    ob_clean();
	include ('connect.php');

	function generateRow($from, $to, $conn, $deduction){
		$contents = '';
	 	if($_POST['dept']=='all')
      {
      	$sql = "SELECT *, sum(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";
      }
      else
      {
      	$sql = "SELECT *, sum(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC"; 
      }
		

		$query = $conn->query($sql);
		$total = 0;
		while($row = $query->fetch_assoc()){
			$empid = $row['empid'];
			$e = $row['employee_id'];
			
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
					 
			
               
            /*$otsql = "SELECT *, SUM(rate) as overtime FROM overtime WHERE employee_id='$empid' AND date BETWEEN '$from' AND '$to'";
			$otquery = $conn->query($otsql);
			$orow = $otquery->fetch_assoc();
			$overtime = $orow['overtime'];*/
			
			
			
			/*$sql1 = "SELECT SUM(amt) AS inc FROM incentive WHERE employee_id='$empid' AND date_incentive BETWEEN '$from' AND '$to'";
                      
					  
                      $query1 = $conn->query($sql1);
                      $row1 = $query1->fetch_assoc();
					  $incentive = $row1['inc'];*/
			
			   
	      	/*$casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
	      
	      	$caquery = $conn->query($casql);
	      	$carow = $caquery->fetch_assoc();
	      	$cashadvance = $carow['cashamount'];*/
			
			
			$sd = "SELECT *, SUM(amount) as td FROM deductions WHERE empid='$e' AND date BETWEEN '$from' AND '$to'";
                     $queryd = $conn->query($sd);
                     $drow = $queryd->fetch_assoc();
                     $deduction = $drow['td'];
			

			/*$gross = $sal + $overtime + $incentive;
			$total_deduction = $deduction + $cashadvance;
      		$net = $gross - $total_deduction;*/

      		$gross = $sal;
			$total_deduction = $deduction;
      		$net = $gross - $total_deduction;

			$total += $net;
			$contents .= '
			<tr>
			<td>'.$department_name.'</td>
				<td>'.$row['lastname'].' '.$row['firstname'].'</td>
				<td>'.$row['employee_id'].'</td>
				<td align="right">'.number_format($net, 2).'</td>
			</tr>
			';
		}

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td align="right"><b>'.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}
		
	$range = $_POST['date_range'];
	$ex = explode(' - ', $range);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));

	$sql = "SELECT *, SUM(amount) as total_amount FROM deductions";
    $query = $conn->query($sql);
   	$drow = $query->fetch_assoc();
    $deduction = $drow['total_amount'];

	$from_title = date('M d, Y', strtotime($ex[0]));
	$to_title = date('M d, Y', strtotime($ex[1]));

	require_once('tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Payroll: '.$from_title.' - '.$to_title);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">'.$_SESSION['company'].'</h2>
      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr> 
           <th width="25%" align="center"><b>Department Name</b></th> 
   		<th width="25%" align="center"><b>Employee Name</b></th>
        <th width="25%" align="center"><b>Employee ID</b></th>
		<th width="25%" align="center"><b>Net Pay</b></th> 
           </tr>  
      ';  
    $content .= generateRow($from, $to, $conn, $deduction);  
    $content .= '</table>';  
    $pdf->writeHTML($content);
    ob_end_clean();	
    $pdf->Output('payroll.pdf', 'I');

?>