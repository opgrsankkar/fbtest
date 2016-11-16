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
            <div id="friends-div" class="row">
                <?php
                connect();
                $sql = 'SELECT user_id,fname,lname FROM users where
                        user_id in (select user_id2 as u_id FROM friends where (user_id1='.$user_id.') and ACCEPT_DATE is not null) OR
                        user_id in (select user_id1 as u_id FROM friends where (user_id2='.$user_id.') and ACCEPT_DATE is not null)';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row_cursor = $result->fetch_assoc()) { ?>
                    <div class="box photo-display">
                            <a href="posts.php?v_id=<?= $row_cursor['user_id'] ?>"><span class="posted-by"><?= $row_cursor['fname'] ?> </span>
                                    <span class="posted-by"> <?= $row_cursor['lname'] ?> </span> </a>
                    </div>
                <?php
                    }
                } disconnect();?>
            </div>
    </body>
</html>