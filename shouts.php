<?php
include 'dbconn.php';
include 'magic.php';
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
		<link rel="stylesheet" type="text/css" href="simple-grid.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="jquery-3.1.0.min.js"></script>
        <script>
            var scrolled = false;
            var shoutDivId = "shouts-div";
            function updateScroll(){
                if(!scrolled){
                    var element = document.getElementById(shoutDivId);
                    element.scrollTop = element.scrollHeight;
                }
            }
            $(shoutDivId).on('scroll', function(){
                scrolled=true;
            });
        </script>
	</head>
    <body onload="updateScroll()">
        <div id="shouts-div" class="shouts">
            <?php
                connect();
                $sqlP = "SELECT user_id,fname,lname,content,UNIX_TIMESTAMP(add_date) as add_date FROM shout NATURAL JOIN users";
                $resultP = $conn->query($sqlP);
                if ($resultP->num_rows > 0) {
                    while($row_cursorP = $resultP->fetch_assoc()) { ?>
                    <p class="">
                        <strong><?=$row_cursorP['fname']?> <?=$row_cursorP['lname']?></strong>
                        <?= $row_cursorP['content']?>
                        <span class="shout-time"><?= before($row_cursorP['add_date']) ?></span>
                    </p>
                <?php
                    }
                } 
                disconnect();?>
        </div>
        <div class="shout-input row">
            <form method="post" action="addShouts.php">
                <input class="col-8-sm" maxlength="100" type="text" name="shout_content" placeholder="Shout here..">
                <button class="col-3-sm btn" style="padding:2px;" type="submit">Shout!</button>
            </form>
        </div>
    </body>
</html>