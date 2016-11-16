<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
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
			<span class=""><a href="post.php">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
		</div>
        <div class="display-friends">
            <div class="row">
                <?php
                    $friendext = "SELECT user_id1,user_id2 FROM RIENDS WHERE  user_id1='".$_SESSION['user_id']."'";
                    $result = $conn->query($friendext);
                    if($result->num_rows >0){
                        while($row_cursor = $result->fetch_assoc()){
                            $sel_result="SELECT user_id2 from friends where users.user_id=user_id2 and user_id1='".$_SESSION['user_id']."'";
                            echo  $sel_result;
                            echo " ";
                        }
                    }
                 ?>   
                 </div>
            </div>        
    </body>
</html>