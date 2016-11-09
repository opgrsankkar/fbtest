<?php
include 'dbconn.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass'];
$email=$_POST['email'];
$dob=$_POST['dob'];


$sql="INSERT INTO users(fname,lname,password,email,dob) VALUES('$firstname','$lastname','$pass','$email','$dob')";

connect();
if ($conn->query($sql) === TRUE) {
	echo "New User added";
	header('Location: login.php');
} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
}
disconnect();
?>
