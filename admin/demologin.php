<?php session_start(); ?>

<!DOCTYPE HTML>

<?php

include("connect.php");
$message="";
if(isset($_POST['login']))
{
$unm = $_POST['username'];
//$p="admin";
$passw = hash('sha256', $_POST['passwd']);
//$passw = hash('sha256',$p);
//echo $passw;exit;
function createSalt()
{
    return '2123293dsj2hu2nikhiljdsd';
}
$salt = createSalt();
$pass = hash('sha256', $salt . $passw);
//echo $pass;exit;
 $sql = "SELECT * FROM admin WHERE username='" .$unm . "' and password = '". $pass."'";
	$result = mysqli_query($conn,$sql);
	$row  = mysqli_fetch_array($result);
	
	 $_SESSION["id"] = $row['id'];
	 $_SESSION["pass"] = $row['password'];
	 $_SESSION["email"] = $row['username'];
	 $_SESSION["fname"] = $row['firstname'];
	 $_SESSION["lname"] = $row['lastname'];
	 $_SESSION["image"] = $row['image'];
	 $count=mysqli_num_rows($result);
     if(count($result)==1 && isset($_SESSION["email"]) && isset($_SESSION["pass"])) 
    {
	      
        ?>
	 <script>
     window.location="dashboard.php";
     </script>
	 <?php
    }

else {?>
		<script> 
		alert("Invalid Username or Password!");
		window.location="index.php";
		</script>
		<?php
	     $message = "Invalid Username or Password!";
	     }
	
	}
?>


 
	<!--header-->
	