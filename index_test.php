<?php include'dbconn.php'; 
      include 'magic.php';
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
        <script>
            function postOptions(option, post_id) {
                if(option=='deletePost'){
                    var r = confirm("Sure to delete the post?");
                    if (r == true) {
                        $.post("deletePost.php",{ p_id: post_id });
                    } else {
                        window.location.href = "index.php";                        
                    }
                } else if (option=='editPost') {
                    window.location.href = "editPost.html";
                }
            }
        </script>
	</head>
<body>
    <div class="middle-content">
            <div id="posts">
                <?php 
                    connect();
                    $sql = 'SELECT post_id,fname,lname,content,UNIX_TIMESTAMP(add_date) AS add_date FROM post NATURAL JOIN users ORDER BY add_date DESC';
                    $result = $conn->query($sql);

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
        </div>
</body>
</html>