<?php
//session_start();// Starting Session
include("../connect.php");
if(isset($_SESSION["id"])){// Storing Session
// SQL Query To Fetch Complete Information Of User
$user=$_SESSION["id"];
$ses_sql=mysqli_query($conn,"select * from superadmin where id = '$user'");
//echo $user_check;
$row = mysqli_fetch_assoc($ses_sql);
$my_id =  $row['id'];
$my_email =$row['username']; 
$my_fname =$row['firstname'];
$my_lname =$row['lastname'];
$my_file=$row['image'];
}

mysqli_close($conn); // Closing Connection
//header('Location: usertbl.php'); // Redirecting To Home Page

?>