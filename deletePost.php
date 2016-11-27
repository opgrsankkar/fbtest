<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';

connect();
$post_id = $_POST['p_id'];
echo $post_id.'<br>';

$stmt = $conn->prepare("DELETE FROM POST WHERE POST_ID = ?");
$stmt->bind_param("i",$post_id);

if ($stmt->execute() === TRUE) {
	// header('Location: '.$_SERVER['REQUEST_URI']);
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

disconnect();
?>
