<?php session_start();
// include("connect.php");
// session_start();
//  echo $id=$_POST['id'];die;
//   $getselect=mysqli_query($conn,"SELECT * FROM employees where department_id='$id' AND admin_id='".$_SESSION['id']."'");

// $result=array();
// while($rows = mysqli_fetch_array($getselect))
//   {
//     $result=$rows;
//     // print_r($result);
   
    
// }

// echo json_encode($result);
?>

<?php
include("connect.php");

echo $id=$_POST['id'];
if($id=="all"){
    $sqlwhere="admin_id='".$_SESSION['id']."'";
}else{
   $sqlwhere ="department_id='$id' AND admin_id='".$_SESSION['id']."'";
}

// $state_id = $_POST["state_id"];
$result =mysqli_query($conn,"SELECT * FROM employees where $sqlwhere");
?>
<option value="">Select Name</option>
<?php
while($row = mysqli_fetch_array($result)) {
?>
<option value="<?php echo $row['eid'] ?>"><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></option>
<?php
}
?>