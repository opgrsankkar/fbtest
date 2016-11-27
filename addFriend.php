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
$sql = "SELECT ACCEPT_DATE FROM FRIENDS WHERE (USER_ID1=".$sender_id." AND USER_ID2=".$receiver_id.") OR ".
                                            "(USER_ID2=".$sender_id." AND USER_ID1=".$receiver_id.")";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if($row['accept_date']==NULL){
            $stmt = $conn->prepare("DELETE FROM FRIENDS WHERE USER_ID1=? AND USER_ID2=?");
            $stmt->bind_param("ii",$sender_id,$receiver_id);
            if ($stmt->execute() === TRUE) {
               echo "Request deleted<br>";
            } else {
	            echo "Error<br>" . $conn->error;
            }
            $stmt = $conn->prepare("UPDATE FRIENDS SET ACCEPT_DATE = NOW() WHERE USER_ID1=? AND USER_ID2=?");
            $stmt->bind_param("ii",$receiver_id,$sender_id);
            if ($stmt->execute() === TRUE) {
               echo "Request Accepted<br>";
            } else {
	            echo "Error<br>" . $conn->error;
            }
        }
        else {
            $stmt = $conn->prepare("DELETE FROM FRIENDS WHERE (USER_ID1=? AND USER_ID2=?) OR (USER_ID1=? AND USER_ID2=?)");
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
    $stmt = $conn->prepare("INSERT INTO FRIENDS(USER_ID1,USER_ID2,REQUEST_DATE) VALUES(?,?,NOW())");
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