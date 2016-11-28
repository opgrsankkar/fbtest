<?php
include 'dbconn.php';
include 'magic.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];
$visiting_id = 0;
if(isset($_GET['v_id'])){
    $visiting_id = $_GET['v_id'];
}
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
                        $.post("deletePost.php",{ p_id: post_id,u_id :user_id });
                        window.location.href = "index.php";
                } else if (option=='editPost') {
                    window.location.href = "editPost.html";
                }
            }
            function friendStatusMouseOver()
            {
                var buttonContent = document.getElementById("friend_status").innerHTML.trim();
                if(buttonContent == "Request Sent"){
                    document.getElementById("friend_status").innerHTML = "Delete Request";
                }
                if(buttonContent == "Friends :)"){
                    statusButton.innerHTML = "Unfriend";
                }
            }
            function friendStatusMouseOut()
            {
                var buttonContent = document.getElementById("friend_status").innerHTML.trim();
                if(buttonContent == "Delete Request"){
                    document.getElementById("friend_status").innerHTML = "Request Sent";
                }
                if(buttonContent == "Unfriend"){
                    statusButton.innerHTML = "Friends :)";
                }
            }
        </script>
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
            <div id="profile-header" class="row">
                <?php 
                    connect();
                    $sqlprofile = "SELECT FNAME,LNAME,DP FROM USERS WHERE USER_ID=$visiting_id";
                    $resultprofile = $conn->query($sqlprofile);

                    if ($resultprofile->num_rows > 0) {
                    	while($row_cursor_profile = $resultprofile->fetch_assoc()) { ?>
                        <?php
                            $dplink = $row_cursor_profile['DP'];
                            if($dplink==''){
                                $dplink='"photos/empty_profile.png"';
                            }
                            else{
                                $dplink='"photos/'.$row_cursor_profile['DP'].'"';
                            }
                        ?>
                            <img class="col-2-sm box" src=<?= $dplink?> />
                            <span id="profile-name" class="col-5"><?= $row_cursor_profile['FNAME']?> <?= $row_cursor_profile['LNAME'] ?>'s Profile</span>
                            <form method="post" action="addFriend.php">
                                <input type="text" name="receiver_id" value="<?= $visiting_id ?>" hidden>
                                <input type="text" name="sender_id" value="<?= $user_id ?>" hidden>
                                <a class="" id="add_dp_button" class="col-3" href="adddp.php"<?php if($visiting_id!=$user_id) {echo "hidden";}?>>Change DP
                                </a><br>
                                <a class="" id="delete_dp_button" class="col-3" href="deletedp.php"<?php if($visiting_id!=$user_id) {echo "hidden";}?>>Delete DP
                                </a>
                                <button id="friend_status" onmouseover="friendStatusMouseOver()" onmouseout="friendStatusMouseOut()" class="col-3" type="submit"<?php if($visiting_id==$user_id) {echo "hidden";}?>>
                                    <?php
                                        $sql = "SELECT ACCEPT_DATE FROM FRIENDS WHERE USER_ID1=".$visiting_id." AND USER_ID2=".$user_id;
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
		                                        if($row['ACCEPT_DATE']==NULL){echo "Accept Request";}
                                                else {echo "Friends :)";}
                                            }
                                        } else {
                                            $sql = "SELECT ACCEPT_DATE FROM FRIENDS WHERE USER_ID1=".$user_id." AND USER_ID2=".$visiting_id;
                                            $result = $conn->query($sql);
                                            if ($result->num_rows == 0) {echo "Add Friend";}
                                            else {
                                                while($row = $result->fetch_assoc()) {
                                                    if($row['ACCEPT_DATE']==NULL){echo "Request Sent";}
                                                    else {echo "Friends :)";}
                                                }
                                            }
                                        }
                                    ?>
                                </button>
                            </form>
                        <?php }
                    }?>
            </div>
            <div id="posts">
                <?php 
                    connect();
                    $sql = 'SELECT POST_ID,USER_ID,FNAME,LNAME,DP,CONTENT,UNIX_TIMESTAMP(ADD_DATE) AS ADD_DATE FROM POST NATURAL JOIN USERS WHERE
                        USER_ID ='.$visiting_id.' AND (
                        USER_ID IN (SELECT USER_ID2 AS U_ID FROM FRIENDS WHERE (USER_ID1='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR
                        USER_ID IN (SELECT USER_ID1 AS U_ID FROM FRIENDS WHERE (USER_ID2='.$user_id.') AND ACCEPT_DATE IS NOT NULL) OR 
                        USER_ID IN (SELECT USER_ID AS U_ID FROM USERS WHERE USER_ID='.$user_id.'))
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
		                    <div class="box">
                                <p class="row">
                                    <img class="col-2-sm box dp-in-post" src=<?= $dplink?> />
                                    <span class="col-9-sm"><a href="posts.php?v_id=<?= $row_cursor['USER_ID'] ?>"><span class="posted-by"><?= $row_cursor['FNAME'] ?> </span>
                                    <span class="posted-by"> <?= $row_cursor['LNAME'] ?> </span> </a>
                                    <span class="posted-on"> <?= before($row_cursor['ADD_DATE']) ?></span></span>
                                    <?php $post_id=$row_cursor['POST_ID']; ?>
                                    <span class="col-1-sm">
                                        <select onchange="postOptions(this.value,<?= $post_id ?>,<?= $user_id ?>)" class="post-options">
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
                            </div>
	                    <?php 
                        }
                    }
                ?>
                <?php disconnect(); ?> 
            </div>
        </div>
	</body>
</html>