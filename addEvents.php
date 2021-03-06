<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';

connect();
 
$curr_date_time = date("Y-m-d H:i:s");
$event_add_time = (microtime(true))*10000;
$u_id = $_SESSION['user_id'];
$event_name = $_POST['event_name'];
$event_desc = $_POST['event_description'];

$viewershipphp = 'friends';
$start_date_time = $_POST['start_date'].' '.$_POST['start_time'];
$end_date_time = $_POST['end_date'].' '.$_POST['end_time'];
echo $start_date_time;
echo $end_date_time;

$stmt = $conn->prepare("INSERT INTO EVENTS (EVENT_ID,USER_ID, EVENT_NAME, ADD_DATE, START_DATE, END_DATE, EVENT_DESC, VIEWERSHIP) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissssss", $event_add_time, $u_id, $event_name, $curr_date_time, $start_date_time, $end_date_time, $event_desc, $viewershipphp);

if ($stmt->execute() === TRUE) {
    echo "New Event added";
} else {
    echo "Error: <br>" . $conn->error;
}

disconnect();
header('Location: events.php');
?>