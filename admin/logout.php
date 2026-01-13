<?php  

	session_start(); //to ensure you are using same session
	if(isset($_SESSION["id"]))
	{
		session_destroy();
		header('location:index.php');

	}else if(isset($_SESSION["empid"]))
	{
		session_destroy(); //destroy the session
		header('location:employee_index.php');

	}else{
		session_destroy(); //destroy the session
		header('location:index.php');
	}

  	exit();
?>