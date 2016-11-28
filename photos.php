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
            <span class="col-2-sm"><a href="index.php" style="text-decoration:none;">F.R.I.E.N.D.S</a></span>
            <span class="col-6-sm"></span>
            <span id="navbarname" class="col-1-sm"><?php echo $_SESSION['fname']?></span>
            <span class="col-1-sm">
                <a href="mailto:fbtests.reportbug@gmail.com?Subject=Bug%20Report%20on%20FRIENDS">
                    <img src="photos/contribute_bug.png" title="Report Bug" style="max-height:1em;width:auto;">
                </a>
            </span>
            <span id="logoutbtn" class="col-1-sm"><a href="logout.php" tabindex="-1">!</a></span>
        </nav>
		<div id="sidenav" class="sidenav">
            <span class=""><a href="index.php">Feed</a></span>
			<span class=""><a href="posts.php?v_id=<?= $user_id ?>">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
            <span class=""><a href="friends.php">Friends
                        <?php
                            connect();
                            $sqlcount = 'SELECT COUNT(USER_ID) AS P_F FROM USERS WHERE  
                                USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NULL)';
                            $result = $conn->query($sqlcount);
                            if ($result->num_rows > 0) {
                                while($row_cursor = $result->fetch_assoc()) { 
                                    $p_f = $row_cursor['P_F'];
                                    if($p_f==0){
                                        echo '';
                                    }
                                    else{
                                        echo '<span class="badge">'.$row_cursor['P_F'].'</span>';
                                    }
                                }
                            }
                            disconnect();
                            ?>    
                </a>
            </span>
            <span class="shouts-link"><a href="shouts.php">Shouts</a></span>
            <span class="report-bug"><a href="mailto:fbtests.reportbug@gmail.com?Subject=Bug%20Report%20on%20FRIENDS">Report Bug</a>
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

