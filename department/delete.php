<?php
//session_start();// Starting Session
include("../connect.php");
if(isset($_GET["account"])){
$sql="UPDATE admin SET delete_status=1 WHERE id='".$_GET['account']."'";   
	if(mysqli_query($conn,$sql))
          {
            $_SESSION['reply']='success';
            echo '<script>window.location="account.php"</script>';
          }
          else {
            $_SESSION['reply']='danger';
            echo '<script>window.location="account.php"</script>';
          } 
}

?>