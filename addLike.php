<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';
connect();

$curr_date_time = date("Y-m-d H:i:s");
$u_id=$_GET['u_id'];
$p_id=$_GET['p_id'];

$stmt = $conn->prepare("INSERT INTO POST_LIKE (LIKE_DATE,POST_ID, USER_ID) VALUES(?, ?, ?)");
$stmt->bind_param("sii",
    $curr_date_time,
    $p_id,
    $u_id);

if ($stmt->execute() === TRUE) {
    echo "Post Liked<br>";
} else {
    disconnect();
    connect();
	$stmtd = "DELETE FROM POST_LIKE WHERE POST_ID= ".$p_id." AND USER_ID= ".$u_id.";";
    if ($conn->query($stmtd) === TRUE) {
        echo "Post UnLiked<br>";
    }
}
disconnect();
header("Location: index.php#".$p_id);
?>