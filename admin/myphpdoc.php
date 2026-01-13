<?php 
 include("connect.php");
 	$cust = $_POST['cust']; // post variable has the same name as in the ajax data array

    $sql = mysqli_query($conn, "SELECT currency FROM customer WHERE comp_name = '$cust'");
    $row = mysqli_fetch_array($sql);
    echo json_encode($row);
?>