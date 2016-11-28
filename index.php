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
            function postOptions(option, post_id, user_id) {
                if(option=='deletePost'){
                        $.post("deletePost.php",{ p_id: post_id, u_id :user_id });
                        // window.location.href = "index.php";
                } else if (option=='editPost') {
                    window.location.href = "editPost.html";
                }
            }
        </script>
	</head>
	<body class="row">
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
                    $sql = 'SELECT POST_ID,USER_ID,FNAME,LNAME,DP,CONTENT,UNIX_TIMESTAMP(ADD_DATE) AS ADD_DATE FROM POST NATURAL JOIN USERS WHERE
                        USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE (USER_ID1='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR
                        USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR 
                        USER_ID IN (SELECT USER_ID AS U_ID FROM USERS WHERE USER_ID='.$user_id.')
                        ORDER BY ADD_DATE DESC';
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
		                    <div id=<?= '"'.$row_cursor['POST_ID'].'"' ?> class="box">
                                <p class="row">
                                    <img class="col-2-sm box dp-in-post" src=<?= $dplink?> />
                                    <span class="col-9-sm"><a href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>"><span class="posted-by"><?= $row_cursor['FNAME'] ?> </span>
                                    <span class="posted-by"> <?= $row_cursor['LNAME'] ?> </span> </a>
                                    <span class="posted-on"> <?= before($row_cursor['ADD_DATE']) ?></span></span>
                                    <?php $post_id=$row_cursor['POST_ID']; ?>
                                    <span class="col-1-sm">
                                        <select onchange="postOptions(this.value,<?= $post_id ?>,<?= $user_id?>)" class="post-options">
                                            <option value=""></option>
                                            <option value="deletePost">Delete Post</option></span>
                                        </select>
                                    </span>
                                </p>
                                <p id="post_content" class="row post"> <?php echo $row_cursor['CONTENT'] ?></p>
                                <div id="photos-div" class="row">
                                    <?php 
                                    $sqlP = "SELECT PHOTO_ID,LINK FROM PHOTOS WHERE POST_ID='".$post_id."'";
                                    $resultP = $conn->query($sqlP);
                                    if ($resultP->num_rows > 0) {
                                        while($row_cursorP = $resultP->fetch_assoc()) { ?>
                                        <img class="photo-display" src="<?= 'photos/'.$row_cursorP['LINK'] ?>">
                                    <?php
                                        }
                                    } ?>
                                </div>
                                <hr>
                                <div class="">
                                    <span class="num-likes"><?php $sql = 'SELECT COUNT(USER_ID) AS NUM_LIKES FROM POST_LIKE WHERE POST_ID='.$row_cursor['POST_ID'];
                                        $result_like = $conn->query($sql);
                                        if ($result_like->num_rows > 0) {
                    	                    while($row_cursor_like = $result_like->fetch_assoc()) { ?>
                                                <?= $row_cursor_like['NUM_LIKES'] ?> Likes
                                            <?php
                                            }
                                        }?></span>
                                        <span class="like-btn"><a href=<?= '"addLike.php?u_id='.$user_id.'&p_id='.$post_id.'"' ?>>
                                            <?php
                                                $like_stmt = 'SELECT USER_ID AS NUM_LIKES FROM POST_LIKE WHERE POST_ID='.$row_cursor['POST_ID'].' AND USER_ID='.$user_id;
                                                $result_liked = $conn->query($like_stmt);
                                                if ($result_liked->num_rows == 0) {
                    	                            echo "Like";
                                                }
                                                else{
                                                    echo "Unlike";
                                                }
                                            ?>
                                            </a></span>
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