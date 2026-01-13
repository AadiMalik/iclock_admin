<?php session_start(); ?>

<!DOCTYPE HTML>

<?php
include("connect.php");
$message="";
if(isset($_POST['login']))
{
	$unm = $_POST['emp_id'];
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
	 	$sql = "SELECT * FROM employees WHERE 	employee_id='" .$unm . "' and password = '". $pass."'";
		$result = mysqli_query($conn,$sql);
		$row  = mysqli_fetch_array($result);
		$_SESSION["empid"] = $row['employee_id'];
		$_SESSION["pass"] = $row['password'];
		 //$_SESSION["email"] = $row['username'];
		$_SESSION["fname"] = $row['firstname'];
		$_SESSION["lname"] = $row['lastname'];
		// $_SESSION["image"] = $row['image'];
		 $count=mysqli_num_rows($result);
	    if(count($result)==1 && isset($_SESSION["empid"]) && isset($_SESSION["pass"]))
		{       			
			date_default_timezone_set("Asia/Kolkata");
			$result_emp_atten = mysqli_query($conn,"SELECT * FROM attendance WHERE employee_id='" .$row['employee_id']. "' && date = '".date('Y-m-d')."'");
			if(mysqli_num_rows($result_emp_atten) > 0)
			{
?>
			 	<script>
		     		window.location="emp_dashboard.php";
		     	</script>
<?php
			}else{
?>
					<script>
			     		window.location="employee_index.php";
			     		$message = "Employee Not Present";
			     	</script>
<?php
			}
    	}else
    	{
?>
			<script> 
				alert("Invalid Username or Password!");
				window.location="employee_index.php";
			</script>
<?php
	    		$message = "Invalid Username or Password!";
	   	}	
}
?>

