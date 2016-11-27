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
			<span class=""><a href="posts.php?v_id=<?= $user_id?>">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
            <span class=""><a href="friends.php">Friends</a></span>
            <span class="shouts-link"><a href="shouts.php">Shouts</a></span>
		</div>
        <div class="middle-content">
        <div id="requests-div" class="row" style="padding-bottom:20px;">
                <span id="profile-header">Pending Requests</span>
                <?php
                connect();
                $sql = 'SELECT USER_ID,FNAME,LNAME,DP FROM USERS WHERE 
                        USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE (USER_ID1='.$user_id.') AND ACCEPT_DATE IS NULL) OR 
                        USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NULL)';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row_cursor = $result->fetch_assoc()) { ?>
                    <?php
                            $dplink = $row_cursor['DP'];
                            if($dplink==''){
                                $dplink='"photos/empty_profile.png"';
                            }
                            else{
                                $dplink='"photos/'.$row_cursor['DP'].'"';
                            }
                        ?>
                    <div class="box row" style="margin: 10px;">
                            <a href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <img class="col-2-sm box" src=<?= $dplink?> />
                            </a>
                            <a class-"col-9-sm" href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <span class="posted-by"><?= $row_cursor['FNAME'] ?> </span>
                                <span class="posted-by"> <?= $row_cursor['LNAME'] ?> </span>
                            </a>
                    </div>
                <?php
                    }
                } disconnect();?>
            </div>
            <div id="friends-div" class="row" style="padding-top:20px;">
                <span id="profile-header">Your Friends</span>
                <?php
                connect();
                $sql = 'SELECT USER_ID,FNAME,LNAME,DP FROM USERS WHERE
                        USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE (USER_ID1='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR
                        USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NOT NULL)';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row_cursor = $result->fetch_assoc()) { ?>
                    <?php
                            $dplink = $row_cursor['DP'];
                            if($dplink==''){
                                $dplink='"photos/empty_profile.png"';
                            }
                            else{
                                $dplink='"photos/'.$row_cursor['DP'].'"';
                            }
                        ?>
                    <div class="box row" style="margin: 10px;">
                            <a href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <img class="col-2-sm box" src=<?= $dplink?> />
                            </a>
                            <a class-"col-9-sm" href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <span class="posted-by"><?= $row_cursor['FNAME'] ?> </span>
                                <span class="posted-by"> <?= $row_cursor['LNAME'] ?> </span>
                            </a>
                    </div>
                <?php
                    }
                } disconnect();?>
            </div>
            <div id="others-div" class="row" style="padding-top:20px;">
                <span id="profile-header">Other People</span>
                <?php
                connect();
                $sql = 'SELECT USER_ID,FNAME,LNAME,DP FROM USERS WHERE USER_ID NOT IN (SELECT USER_ID FROM USERS WHERE
                        USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE USER_ID1='.$user_id.') OR
                        USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE USER_ID2='.$user_id.') OR
                        USER_ID IN (SELECT USER_ID AS U_ID FROM USERS WHERE USER_ID='.$user_id.'))';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row_cursor = $result->fetch_assoc()) { ?>
                    <?php
                            $dplink = $row_cursor['dp'];
                            if($dplink==''){
                                $dplink='"photos/empty_profile.png"';
                            }
                            else{
                                $dplink='"photos/'.$row_cursor['DP'].'"';
                            }
                        ?>
                    <div class="box row" style="margin: 10px;">
                            <a href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <img class="col-2-sm box" src=<?= $dplink?> />
                            </a>
                            <a class-"col-9-sm" href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>">
                                <span class="posted-by"><?= $row_cursor['FNAME'] ?> </span>
                                <span class="posted-by"> <?= $row_cursor['LNAME'] ?> </span>
                            </a>
                    </div>
                <?php
                    }
                } disconnect();?>
            </div>
    </body>
</html>