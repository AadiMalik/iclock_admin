<?php 
require "config.php";
$mobile = $_POST["mobile"];

$mysql_qry = "select * from employees where employee_id like '$mobile';";// and isActive like '1'
$result = mysqli_query($conn ,$mysql_qry);

if(mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$expiry_date = $row['expiry_date'] ;
$curr_date=date("Y-m-d");
if($expiry_date >= $curr_date){
echo "login success !!!!! Welcome user";
}else{
    echo "Expired !!!";
}

}
else {
echo "login not success";
}

?>