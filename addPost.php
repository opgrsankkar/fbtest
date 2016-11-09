<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';

connect();
$curr_date_time = date("Y-m-d H:i:s");
$sql="INSERT INTO post(user_id,datep,content,viewership) VALUES('".
    $_SESSION['user_id']."','".
    $curr_date_time."','".
    $_POST['postcontent']."','".
    "friends');";

if ($conn->query($sql) === TRUE) {
	echo "Your Post has been posted";
	header('Location: index.php');
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

disconnect();
?>