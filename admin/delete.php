<?php
//session_start();// Starting Session
include("../connect.php");
if(isset($_GET["department"])){
$sql="UPDATE department SET delete_status=1 WHERE id='".$_GET['department']."'";   
	if(mysqli_query($conn,$sql))
          {
            $_SESSION['reply']='success';
            echo '<script>window.location="department.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="department.php"</script>';
          } 
}

?>