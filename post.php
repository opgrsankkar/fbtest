<?php
$user_id=0;
include 'dbconn.php';
include 'magic.php';

if(session_status() === PHP_SESSION_NONE)
{
        session_start();
        if($_SESSION['fname']==''){header('location : login.php');
        }
}
$user_id=$_SESSION['user_id'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
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
			<span class=""><a href="post.php">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
            <span class=""><a href="friends.php">Friends</a></span>
	</div>
    <div class="middle-content">
            <div id="posts">
                <?php
                    connect();
                    $sql = "SELECT post_id,fname,lname,content,UNIX_TIMESTAMP(add_date) AS add_date FROM post NATURAL JOIN users WHERE user_id='".$user_id."' ORDER BY add_date DESC";
                    $result = $conn->query($sql);
 //                   echo $user_id;
                    if ($result->num_rows > 0) {
                    	while($row_cursor = $result->fetch_assoc()) { ?>
		                    <div class="box">
                            <p> <span class="posted-by"><?= $row_cursor['fname'] ?> </span>
                                <span class="posted-by"> <?= $row_cursor['lname'] ?> </span>
                                <span class="posted-on"> <?= before($row_cursor['add_date']) ?></span>
                                <?php $post_id=$row_cursor['post_id']; ?>
                                <span class="col-1">
                                    <select onchange="postOptions(this.value,<?= $post_id ?>)" class="post-options">
                                        <option value=""></option>
                                        <option value="deletePost">Delete Post</option></span>
                                        <option value="editPost">Edit Post</option></span>
                                    </select>
                                </span>
                            </p>
                            <p id="post_content" class="row post"> <?php echo $row_cursor['content'] ?></p>
                            <div id="photos-div" class="row">
                                <?php 
                                $sqlP = "SELECT photo_id,link FROM photos where post_id='".$post_id."'";
                                $resultP = $conn->query($sqlP);
                                if ($resultP->num_rows > 0) {
                    	            while($row_cursorP = $resultP->fetch_assoc()) { ?>
                                    <img class="photo-display" src="<?= 'photos/'.$row_cursorP['link'] ?>">
                                <?php
                                    }
                                } ?>
                            </div>
                            </div>
	                    <?php 
                        }
                    }
                ?>
                <?php disconnect(); ?> 
            </div>





</body>
</html>