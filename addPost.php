<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';

connect();
$curr_date_time = date("Y-m-d H:i:s");
$u_id=$_SESSION['user_id'];
$viewershipphp='friends';
$contents = $_POST['postcontent'];


$stmt = $conn->prepare("INSERT INTO post (user_id, add_date,content,viewership) VALUES( ?, ?, ?, ?)");
$stmt->bind_param("isss",
    $u_id, 
    $curr_date_time,
    $contents,
    $viewershipphp);


if ($stmt->execute() === TRUE) {
    echo "New Post added";
	header('Location: index.php');
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}       
disconnect();
?>