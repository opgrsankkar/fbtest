<?php
    include 'dbconn.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
	    if($_SESSION['fname']==''){header('Location:login.php');}
    }
    if(trim($_POST['shout_content'])!='') {
        $user_id = $_SESSION['user_id'];
        connect();
        $shout_time = (string)(microtime(true))*10000;
        $curr_date_time = date("Y-m-d H:i:s");
        $u_id=$_SESSION['user_id'];
        $contents = $_POST['shout_content'];
        $stmt = $conn->prepare("INSERT INTO SHOUT (SHOUT_ID, USER_ID,CONTENT,ADD_DATE) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("iiss",
            $shout_time,
            $u_id,
            $contents,
            $curr_date_time);
        if ($stmt->execute() === FALSE) {
            echo "Error<br>" . $conn->error;
        }
    }
    header('Location: shouts.php');
?>