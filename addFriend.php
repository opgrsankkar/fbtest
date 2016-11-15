<?php
include 'dbconn.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];

$sender_id=$_POST['sender_id'];
$receiver_id=$_POST['receiver_id'];
?>