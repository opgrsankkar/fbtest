<?php
include 'dbconn.php';
include 'magic.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];

connect();
$sql="UPDATE USERS SET DP='' WHERE USER_ID=$user_id;";
        if ($conn->query($sql) === TRUE) {
        echo "DP deleted";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
header("Location: posts.php?v_id=".$user_id);
disconnect();
?>