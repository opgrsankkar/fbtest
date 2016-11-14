<?php
include 'dbconn.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass'];
$email=$_POST['email'];
$dob=$_POST['dob'];
$user_id = (microtime(true))*1000;

$sql="INSERT INTO users(user_id,fname,lname,password,email,dob) VALUES($user_id,'$firstname','$lastname','$pass','$email','$dob')";

connect();
if ($conn->query($sql) === TRUE) {
	echo "New User added";
	header('Location: login.php');
} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
}
disconnect();
?>
