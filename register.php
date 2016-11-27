<?php
include 'dbconn.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass'];
$email=$_POST['email'];
$dob=$_POST['dob'];
$user_id = (microtime(true))*1000;

$sql="INSERT INTO USERS(USER_ID,FNAME,LNAME,PASSWORD,EMAIL,DOB) VALUES($user_id,'$firstname','$lastname','$pass','$email','$dob')";

connect();
if ($conn->query($sql) === TRUE) {
	echo "New User added";
	header('Location: login.php?e='.$email);
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
disconnect();

?>
