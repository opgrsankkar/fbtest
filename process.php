<?php
include 'dbconn.php';

$name=$_POST['name'];
$pass=$_POST['pass'];

$sql="INSERT INTO USERS(NAME,PASS) VALUES('$name','$pass')";
connect();
if ($conn->query($sql) === TRUE) {
	echo "New User added";
	header('Location: index.html');
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
disconnect();
?>
