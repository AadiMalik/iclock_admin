<?php
session_start();
     ob_clean();
	include 'connect.php';
	
	$range = $_POST['date_range'];
	$ex = explode(' - ', $range);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));
	


	$from_title = date('M d, Y', strtotime($ex[0]));
	$to_title = date('M d, Y', strtotime($ex[1]));

	require_once('tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Payslip: '.$from_title.' - '.$to_title);  
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
    $contents = '';

if($_POST['dept']=='all')
      {
      	$sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";
      }
      else
      {
      	$sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee FROM attendance LEFT JOIN employees ON employees.eid=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.admin_id='".$_SESSION['id']."' AND employees.department_id='".$_POST['dept']."' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";
      }
	

	$query = $conn->query($sql);
	while($row = $query->fetch_assoc()){
		$empid = $row['empid'];
		$e = $row['employee_id'];
		
		$ls = "SELECT SUM(status) AS lst FROM attendance WHERE employee_id='$empid' AND daytype <> 'LWP' AND date BETWEEN '$from' AND '$to'" ;
						$lquery = $conn->query($ls);
						$lrow = $lquery->fetch_array();
						
					    
						$lwp = $lrow['lst'];
		
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

		$contents .= '
			<h2 align="center">I.T.Company</h2>
			<h4 align="center">'.$department_name.'</h4>
			<h5 align="center">'.$from_title." - ".$to_title.'</h5>
			<table cellspacing="0" cellpadding="3">  
    	       	<tr>  
            		<td width="25%" align="right">Employee Name: </td>
                 	<td width="25%"><b>'.$row['firstname']." ".$row['lastname'].'</b></td>
				 	<td width="25%" align="right">Rate per Day: </td>
                 	<td width="25%" align="right">'.number_format($rt, 2).'</td>
    	    	</tr>
    	    	<tr>
    	    		<td width="25%" align="right">Employee ID: </td>
				 	<td width="25%">'.$row['employee'].'</td>   
				 	<td width="25%" align="right">Total Days Present: </td>
				 	<td width="25%" align="right">'.$lwp.'</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td></td> 
    	    		<td></td>
				 	<td width="25%" align="right"><b>Gross Pay: </b></td>
				 	<td width="25%" align="right"><b>'.number_format(($gross), 2).'</b></td> 
    	    	</tr>
    	    	<tr> 
    	    		<td></td> 
    	    		<td></td>
				 	<td width="25%" align="right">Deduction: </td>
				 	<td width="25%" align="right">'.number_format($deduction, 2).'</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td></td> 
    	    		<td></td>
				 	<td width="25%" align="right"><b>Total Deduction:</b></td>
				 	<td width="25%" align="right"><b>'.number_format($total_deduction, 2).'</b></td> 
    	    	</tr>
    	    </table>
    	    <br><hr>
		';
	}
    $pdf->writeHTML($contents); 
    ob_end_clean();		
    $pdf->Output('payslip.pdf', 'I');

?>