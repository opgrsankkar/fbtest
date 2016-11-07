<?php
$servername = "localhost";
$serverUsername = "root";
$serverPassword = "123";
$conn=NULL;
function connect() {
	global $conn;
	$conn = new mysqli('localhost','root','123','fbtest');
	
	if ($conn->connect_error) {
	die("Connection error: " . $conn->connect_error);
	}
}
function disconnect() {
	global $conn;
	$conn->close();
}
?>