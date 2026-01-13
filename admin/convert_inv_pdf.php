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
    /*// Logo
    $this->Image('images/icon.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(150);
    // Title
    $this->Cell(40,10,'Quotation',1,0,'C');
    // Line break
    $this->Ln(15);*/

    include "connect.php";   

    $sql_get_inv = mysqli_query($conn,"SELECT * FROM inv_payment WHERE qut_id ='".$_GET['qut_id']."'");
    $row_inv = mysqli_fetch_array($sql_get_inv);

    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
    $row_qut = mysqli_fetch_array($sql_get_qut);
    
    	$this->SetFont('Arial','',12);
    	$this->Ln(5);
    	$this->Cell(2);
    	$this->Cell(40,0,$row_qut['cust_name'],0,0,'C');
        $this->Cell(120);
        $this->Cell(40,0,"To:",0,0,'C');

    	$this->Ln(5);
    	$this->Cell(1);
    	$this->Cell(40,0,$row_qut['addr'].",".$row_qut['city'],0,0,'C');
        $this->Cell(113);
        $this->Cell(40,0,$row_qut['cust_name'],0,0,'C');

    	$this->Ln(5);
    	$this->Cell(1);
    	$this->Cell(40,0,$row_qut['state'].",".$row_qut['pin_code'],0,0,'C');
    	$this->Ln(10);

    	/*$this->Cell(148);
    	$this->Cell(40,0,'Expiry Date: '.$row_qut['expiry_date'],0,0,'C');
    	$this->Ln(5);
    	$this->Cell(148);
    	$this->Cell(40,0,'Sale Agent: '.$row_qut['sale_agent'],0,0,'C');
    	$this->Ln(20);*/
   
	
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


//$pdf->Cell(30,10,'Amount',1,1);

	include "connect.php";
    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
    $row_qut = mysqli_fetch_array($sql_get_qut);
    
    $sql_get_inv = mysqli_query($conn,"SELECT * FROM inv_payment WHERE qut_id ='".$_GET['qut_id']."'");
    $row_inv = mysqli_fetch_array($sql_get_inv);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(200,0,"PAYMENT RECEIPT",0,0,'C');
        $pdf->Ln(15);

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(29,0,"Payment Date:",0,0,'C');
        $pdf->Cell(45,0,$row_inv['payment_date'],0,0,'C');
        $pdf->Ln(5);
        $pdf->Cell(30,0,"Payment Mode:",0,0,'C');
        $pdf->Cell(31,0,$row_inv['payment_mode'],0,0,'C');
        $pdf->Ln(5);
        $pdf->Cell(29,0,"Transaction ID:",0,0,'C');
        $pdf->Cell(29,0,$row_inv['transaction_id'],0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',18);
        $pdf->SetFillColor(173, 216, 230);
        //$pdf->Cell(80,10,'Hello World!',1,0,true,'https://www.plus2net.com');
        $pdf->Cell(80,18,"Total Amount: $".$row_inv['amount'],1,1,'C',true);
        $pdf->Ln(10);
        
	    $pdf->SetFont('Arial','',12);
        $pdf->SetFillColor(236, 236, 236);
        $pdf->Cell(10,10,'Payment For',0,1);
        $pdf->Cell(30,10,'Invoice ID',1,0,'',true);
        $pdf->Cell(50,10,'Invoice Date',1,0,'',true);
        $pdf->Cell(50,10,'Invoice Amount',1,0,'',true);
        $pdf->Cell(50,10,'Payment Amount',1,1,'',true);

        $pdf->Cell(30,10,$row_inv['inv_id'],1,0);
        $pdf->Cell(50,10,$row_inv['payment_date'],1,0);
        $pdf->Cell(50,10,'$'.$row_inv['amount'],1,0);
        $pdf->Cell(50,10,$row_qut['total'],1,1);
    
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