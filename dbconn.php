<?php
date_default_timezone_set('Asia/Calcutta');
$servername = "localhost";
$serverUsername = "root";
$serverPassword = "";
$databasename = "fbtest";
$conn=NULL;
function connect() {
	global $conn;
	global $servername;
	global $serverUsername;
	global $serverPassword;
	global $databasename;
	$conn = new mysqli($servername,$serverUsername,$serverPassword,$databasename);
	
	if ($conn->connect_error) {
	die("Connection error: " . $conn->connect_error);
	}
}
function disconnect() {
	global $conn;
	$conn->close();
}
?>