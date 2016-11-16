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
            function postOptions(option, post_id) {
                if(option=='deletePost'){
                        $.post("deletePost.php",{ p_id: post_id });                        
                } else if (option=='editPost') {
                    window.location.href = "editPost.html";
                }
            }
        </script>
	</head>
	<body class="row">
		<nav class="row">
            <span class="col-1-sm"></span>
            <span class="col-2-sm">F.R.I.E.N.D.S</span>
            <span class="col-6-sm"></span>
            <span id="navbarname" class="col-1-sm"><?php echo $_SESSION['fname']?></span>
            <span class="col-1-sm"></span>
            <span id="logoutbtn" class="col-1-sm"><a href="logout.php" tabindex="-1">!</a></span>
        </nav>
		<div id="sidenav" class="sidenav">
            <span class=""><a href="#">Feed</a></span>
			<span class=""><a href="posts.php?v_id=<?= $user_id ?>">Posts</a></span>
            <span class=""><a href="photos.php">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
            <span class=""><a href="friends.php">Friends</a></span>
            <span class="shouts-link"><a href="shouts.php">Shouts</a></span>
		</div>
        <div class="col-2"></div>
        <div class="col-6 middle-content">
            <div id="newposttextdiv">
                <form id="addpostform" method="POST" action="addPost.php" enctype="multipart/form-data">
                    <textarea id="newposttext" class="row" name="postcontent" tabindex="1" placeholder="What's on your mind..."></textarea>
                    <div id="post-upload-div" class="row">  
                        <input class="btn col-2-sm" type="submit" value="Post" tabindex="2">
                        <label class="fileContainer col-2-sm">
                            <span class="upload-btn">Add Photos</span>
                            <input type="file" name="uploaded[]" multiple/>
                        </label>
                    </div>
                </form>
            </div>
            <div id="posts">
                <?php 
                    connect();
                    $sql = 'SELECT post_id,user_id,fname,lname,content,UNIX_TIMESTAMP(add_date) as add_date FROM post NATURAL JOIN users where
                        user_id in (select user_id2 as u_id FROM friends where (user_id1='.$user_id.') and ACCEPT_DATE is not null) or
                        user_id in (select user_id1 as u_id FROM friends where (user_id2='.$user_id.') and ACCEPT_DATE is not null) or 
                        user_id  in (select user_id as u_id from users where user_id='.$user_id.')
                        ORDER BY add_date DESC';
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                    	while($row_cursor = $result->fetch_assoc()) { ?>
		                    <div class="box">
                                <p class="row"><span class="col-11-sm"><a href="posts.php?v_id=<?= $row_cursor['user_id'] ?>"><span class="posted-by"><?= $row_cursor['fname'] ?> </span>
                                    <span class="posted-by"> <?= $row_cursor['lname'] ?> </span> </a>
                                    <span class="posted-on"> <?= before($row_cursor['add_date']) ?></span></span>
                                    <?php $post_id=$row_cursor['post_id']; ?>
                                    <?php
                                    echo '<span class="col-1-sm">'
                                        <select onchange="postOptions(this.value,<?= $post_id ?>)" class="post-options">
                                            <option value=""></option>
                                            <option value="deletePost">Delete Post</option></span>
                                            <option value="editPost">Edit Post</option></span>
                                        </select>
                                    </span>
                                    ?>
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
        </div>
        <div class="col-1"></div>
        <div id="right-content" class="col-4">
            <div class="row" style="height:100px;"></div>
            <div class="row">
                <iframe src="shouts.php" height="500px" frameBorder="0"></iframe>
            </div>
        </div>
	</body>
</html>