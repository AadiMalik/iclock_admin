<?php
/* Local Database*/

/*
$servername = "10.131.7.33";
$username   = "admin";
$password   = "xs3apO@%DB@2020";
$dbname     = "iclock_mikado";
*/
// $servername = "localhost";
// $username   = "idamrune_iclocked";
// $password   = "idamrune_wwe";
// $dbname     = "idamrune_iclock";

//$servername = "localhost";
//$username   = "idamrune_User";
//$password   = "e6Nsn#{H,?8m";
//$dbname     = "idamrune_iclockedmik";

$servername = "localhost";
$username   = "fillao_iclock";
$password   = "l+p@}T%i75?_";
$dbname     = "fillao_iclock";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_select_db($conn,$dbname);


?>
