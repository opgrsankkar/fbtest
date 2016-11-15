<?php
include 'dbconn.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];

$sender_id=$_POST['sender_id'];
$receiver_id=$_POST['receiver_id'];
connect();
$sql = "SELECT accept_date FROM friends WHERE (user_id1=".$sender_id." and user_id2=".$receiver_id.") or ".
                                            "(user_id2=".$sender_id." and user_id1=".$receiver_id.")";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if($row['accept_date']==NULL){
            $stmt = $conn->prepare("DELETE FROM FRIENDS WHERE user_id1=? AND user_id2=?");
            $stmt->bind_param("ii",$sender_id,$receiver_id);
            if ($stmt->execute() === TRUE) {
               echo "Request deleted<br>";
            } else {
	            echo "Error<br>" . $conn->error;
            }
            $stmt = $conn->prepare("UPDATE friends SET accept_date = NOW() WHERE user_id1=? AND user_id2=?");
            $stmt->bind_param("ii",$receiver_id,$sender_id);
            if ($stmt->execute() === TRUE) {
               echo "Request Accepted<br>";
            } else {
	            echo "Error<br>" . $conn->error;
            }
        }
        else {
            $stmt = $conn->prepare("DELETE FROM FRIENDS WHERE (user_id1=? AND user_id2=?) or (user_id1=? AND user_id2=?)");
            $stmt->bind_param("iiii",$receiver_id,$sender_id,$sender_id,$receiver_id);
            if ($stmt->execute() === TRUE) {
               echo "Request deleted<br>";
            } else {
	            echo "Error<br>" . $conn->error;
            }
        }
	}
}
elseif($result->num_rows == 0){
    $stmt = $conn->prepare("INSERT INTO friends(user_id1,user_id2,request_date) VALUES(?,?,NOW())");
    $stmt->bind_param("ii",
        $sender_id,
        $receiver_id);

if ($stmt->execute() === TRUE) {
    echo "Request added<br>";
} else {
	echo "Error<br>" . $conn->error;
}
}
disconnect();
header("Location: posts.php?v_id=".$receiver_id);
?>