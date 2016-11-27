<?php
include 'dbconn.php';
include 'magic.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}

$user_id = $_SESSION['user_id'];
?>
<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="simple-grid.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="jquery-3.1.0.min.js"></script>
    </head>

    <body>
    <nav class="row">
    <span class="col-1-sm"></span>
            <span class="col-2-sm">F.R.I.E.N.D.S</span>
            <span class="col-6-sm"></span>
            <span id="navbarname" class="col-1-sm"><?php echo $_SESSION['fname']?></span>
            <span class="col-1-sm"></span>
            <span id="logoutbtn" class="col-1-sm"><a href="logout.php" tabindex="-1">!</a></span>
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
            <div id="photos-div" class="row">
                <?php
                connect();
                $sqlP = "SELECT PHOTO_ID,LINK FROM PHOTOS WHERE USER_ID = '".$user_id."'";
                $resultP = $conn->query($sqlP);
                if ($resultP->num_rows > 0) {
                    while($row_cursorP = $resultP->fetch_assoc()) { ?>
                    <img class="photo-display box" src="<?= 'photos/'.$row_cursorP['LINK'] ?>">
                <?php
                    }
                    } disconnect();?>
            </div>
        </div>
	</body>
</html>

