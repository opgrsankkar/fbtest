<?php
include 'dbconn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		</echo><link rel="stylesheet" type="text/css" href="simple-grid.css">
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
	<body>
		<nav class="row">
            <span class="col-1-sm"></span>
            <span class="col-2-sm">F.R.I.E.N.D.S</span>
            <span class="col-6-sm"></span>
            <span id="navbarname" class="col-1-sm"><?php echo $_SESSION['fname']?></span>
            <span class="col-1-sm"></span>
            <span id="logoutbtn" class="col-1-sm"><a href="logout.php">!</a></span>
        </nav>
		<div id="sidenav" class="sidenav">
            <span class=""><a href="index.php">Feed</a></span>
			<span class=""><a href="posts.php?v_id=<?= $user_id ?>">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
            <span class=""><a href="friends.php">Friends</a></span>
            <span class="shouts-link"><a href="shouts.php">Shouts</a></span>
		</div>
        <div class="middle-content">
            <div class="row" style="padding-bottom: 40px;">
                <h3 class="col-10">Events</h3>
                <span class="col-2"><a href="addEvents.html">Add Event</a></span>
            </div>
                 <?php
                connect();
                $sqle = 'SELECT EVENT_NAME,START_DATE,END_DATE,EVENT_DESC FROM EVENTS NATURAL JOIN USERS WHERE 
                    USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE(USER_ID1='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR 
                    USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR 
                    USER_ID IN(SELECT USER_ID AS U_IS FROM USERS WHERE USER_ID = '.$user_id.')
                    ORDER BY ADD_DATE DESC';
                $resulte = $conn->query($sqle);
                if ($resulte->num_rows > 0) {
                    while($row_cursore = $resulte->fetch_assoc()) { ?>
                        <div class="Event-display box" >
                            <p class="row"><strong class="col-5">Event Name :</strong> <?=$row_cursore['event_name'] ?> </p>
                            <p class="row"><strong class="col-5">Start Date-Time :</strong> <?= $row_cursore['start_date'] ?> </p>
                            <p class="row"><strong class="col-5">End Date-Time :</strong> <?= $row_cursore['end_date'] ?> </p>
                            <p class="row"><strong class="col-5">Event Description :</strong> <?= $row_cursore['event_desc'] ?> </p>    
                        </div>
                    <?php       
                    }
                    } disconnect();?>
        </div>
    </body>
</html>