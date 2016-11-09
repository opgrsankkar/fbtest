<? php
include 'dbconn.php'
connect();

if (session_start()==PHP_SESSION_NONE)
{
    session_start();
    if($_SESSION['fname']==''){header('Location:login.html');}
}

//$userid=$_POST['user_id'];

$getid = $_POST['user_id'];//"SELECT user_id FROM EVENTS WHERE email ='".$_SESSION['email']."'"; 
$dateofevent=strftime('%F'); //$_SERVER['REQUEST_TIME'];
$startdate = $_POST['start_date'];
$enddate   = $_POST['end_date'];
$viewership= $_POST['viewership'];

$sqlevent = "INSERT INTO EVENTS (user_id,date_of_event,start_date,end_date,viewership) VALUES ($getid,'$dateofevent','$startdate','$enddate','$viewership')  ";

if ($conn->query($sqlevent) === TRUE) {
	echo "New Event added";
    {header:(' Location: Events.html');}
}

>