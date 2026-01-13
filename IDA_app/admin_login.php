<?php 
require "config.php";

$username = $_POST["username"];
//$password = $_POST["password"];
$passw = hash('sha256', $_POST['password']);
 function createSalt()
    {
        return '2123293dsj2hu2nikhiljdsd';
    }
    $salt = createSalt();
    $password = hash('sha256', $salt . $passw);

$mysql_qry = "select * from admin where username like '$username' and password like '$password' and delete_status=0 and status=0;";// and isActive like '1'
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