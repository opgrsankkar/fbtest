<?php
include 'dbconn.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$username=$_POST['username'];
$pass=$_POST['pass'];
$email=$_POST['email'];
$dob=$dob['dob'];


$sql="INSERT INTO users(firstname,lastname,username,pass,email,dob) VALUES('$firstname','$lastname','$useranme','$pass','$email','$dob')";
connect();
if ($conn->query($sql) === TRUE) {
	echo "New User added";
	header('Location: login.html');
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
disconnect();
?>
