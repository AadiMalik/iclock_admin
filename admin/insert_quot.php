<?php 
 include("connect.php");
 	
    $sql = mysqli_query($conn,"INSERT INTO quotation(cust_name, quot_no, quot_date, expiry_date, currency, quot_status, reference, sale_agent, discount_type, admin_note,client_note,Terms_&_Conditions ,status) VALUES ('".$_POST['sel_cust']."', '".$_POST['quot_no']."', '".$_POST['quot_date']."', '".$_POST['exp_date']."', '".$_POST['currency']."','".$_POST['quot_status']."','".$_POST['reference']."','".$_POST['sale_agent']."','".$_POST['discount_type']."','".$_POST['admin_note']."','".$_POST['client_note']."','".$_POST['terms_cond']."','0')");
    $row = mysqli_fetch_array($sql);
    echo json_encode($row);
?>