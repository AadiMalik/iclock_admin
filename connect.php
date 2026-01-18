<?php 
/* Local Database*/

/*
$servername = "10.131.7.33";
$username   = "admin";
$password   = "xs3apO@%DB@2020";
$dbname     = "iclock_mikado";
*/
$servername = "localhost";
$username   = "codepulstore_iclock";
$password   = "codepulstore_iclock";
$dbname     = "codepulstore_iclock";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_select_db($conn,$dbname);
/*// for resetting leaves details
$sql2 = "SELECT * FROM employees WHERE MONTH(created_on)='".date('m')."' AND YEAR(created_on)<'".date('Y')."'";
$result2 = mysqli_query($conn,$sql2); //print_r($result2);exit();
if (mysqli_num_rows($result2) > 0) {
    while($rows = mysqli_fetch_assoc($result2)) {
    	$updated=mysqli_query($conn,"UPDATE employees SET vacation_leaves='0',maternity_leaves='0',paternity_leaves='0',off_leaves='0',absence_leaves='0',sick_avail_leave='".$rows['sick_allot_leave']."',avail_leave='".$rows['allot_leave']."' WHERE eid='".$rows['eid']."'") or die();
           mysqli_query($conn,$updated);
    }
}*/

?>

