<?php
require('fpdf.php');

/*
$conect = mysql_connect("localhost", "root", "");
mysql_select_db("db_name", $conect);

$sql = "INSERT INTO table_name (name, email, mobile, comment) VALUES ('".$_POST["name"]."', '".$_POST["email"]."', '".$_POST["mobile"]."', '".$_POST["comment"]."');";

mysql_query($sql);*/


class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('images/icon.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(150);
    // Title
    $this->Cell(40,10,'Quotation',1,0,'C');
    // Line break
    $this->Ln(15);

    include "connect.php";
    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
    while($row_qut = mysqli_fetch_array($sql_get_qut))
    {  
    	$this->SetFont('Arial','B',12);
    	$this->Cell(150);
    	$this->Cell(40,0,$row_qut['qut_id'],0,0,'C');
    	$this->Ln(15);
    	$this->SetFont('Arial','',12);
    	$this->Cell(168);
    	$this->Cell(40,0,'To: ',0,0,'C');
    	$this->Ln(5);
    	$this->Cell(158);
    	$this->Cell(40,0,$row_qut['cust_name'],0,0,'C');
    	$this->Ln(5);
    	$this->Cell(155);
    	$this->Cell(40,0,'Quotation No: '.$row_qut['quot_no'],0,0,'C');
    	$this->Ln(5);
    	$this->Cell(145);
    	$this->Cell(40,0,'Quotation Date: '.$row_qut['quot_date'],0,0,'C');
    	$this->Ln(5);
    	$this->Cell(148);
    	$this->Cell(40,0,'Expiry Date: '.$row_qut['expiry_date'],0,0,'C');
    	$this->Ln(5);
    	$this->Cell(148);
    	$this->Cell(40,0,'Sale Agent: '.$row_qut['sale_agent'],0,0,'C');
    	$this->Ln(20);
    }
	
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->SetFillColor(236, 236, 236);
$pdf->Cell(10,10,'#',1,0,'',true);
$pdf->Cell(60,10,'Item',1,0,'',true);
$pdf->Cell(30,10,'Qty',1,0,'',true);
$pdf->Cell(30,10,'Rate',1,0,'',true);
$pdf->Cell(30,10,'Tax',1,0,'',true);
$pdf->Cell(30,10,'Amount',1,1,'',true);

	include "connect.php";
    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
    while($row_qut = mysqli_fetch_array($sql_get_qut))
    { 
    	$i=1;
        $amt_total = 0;$tax=0;
        $results_item = mysqli_query($conn,"SELECT * FROM item WHERE item_id = '".$row_qut['item_id']."'");

        while($row_item = mysqli_fetch_array($results_item))
        {
			$pdf->Cell(10,10,$i++,1,0);
			$pdf->Cell(60,10,$row_item['item_name'],1,0);
			$pdf->Cell(30,10,$row_item['qty'],1,0);
			$pdf->Cell(30,10,$row_item['rate'],1,0);
			$pdf->Cell(30,10,$row_item['tax'],1,0);
			$pdf->Cell(30,10,$row_item['amount'],1,1);
			$amt_total = $amt_total + $row_item['amount'];
			$tax= $tax + number_format((str_replace("%","",$row_item['tax'])/100) * $row_item['amount'],2,'.','');
		}
	}

	$pdf->Cell(10,10,'',0,1);
	$pdf->Cell(150,10,'',0,0);
	$pdf->Cell(25,10,'Sub Total:',0,0);
	$pdf->Cell(10,10,'$'.number_format($amt_total,2,'.',''),0,1);

	$pdf->Cell(160,10,'',0,0);
	$pdf->Cell(15,10,'Tax:',0,0);
	$pdf->Cell(10,10,'$'.number_format($tax,2,'.',''),0,1);

	$pdf->Cell(160,0,'',0,0);
	$pdf->Cell(15,0,'Total:',0,0);
	$pdf->Cell(10,0,'$'.number_format($amt_total+$tax,2,'.',''),0,1);


	$sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
    while($row_qut = mysqli_fetch_array($sql_get_qut))
    {  
    	$pdf->Cell(10,10,'',0,1);
		$pdf->Cell(25,10,'Terms & Conditions :',0,1);
		
		$pdf->Cell(10,10,$row_qut['Terms_Conditions'],0,1,'L');
    }

    $pdf->Cell(10,30,'Authorized Signature _________________________',0,1,'L');
    
    /*$html = '<html>
    			<body>
    				Hello
    			</body>
    		</html>';
    $pdf=new PDF($html);
    $pdf->WriteHTML($html);*/

/*$pdf->Cell(0,10,'Email : '.$_POST["email"],0,1);
$pdf->Cell(0,10,'Mobile : '.$_POST["mobile"],0,1);
$pdf->Cell(0,10,'Comment : '.$_POST["comment"],0,1);*/

$pdf->Output();
?>