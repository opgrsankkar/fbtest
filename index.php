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
        <script>
            var fieldValue = '';
            function clearContents(element) {
                fieldValue = element.value;
                if(fieldValue == "What's on your mind...")
                    {element.value = '';}
            }
            function addContents(element) {
                if(element.value.length == 0) {
                    element.value = fieldValue;
                }
            }
        </script>
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
            <span class=""><a href="#">Feed</a></span>
			<span class=""><a href="posts.html">Posts</a></span>
            <span class=""><a href="photos.html">Photos</a></span>
            <span class=""><a href="events.php">Events</a></span>
		</div>
        <div class="middle-content">
            <div id="newposttextdiv">
                <form id="addpostform" method="POST" action="addPost.php">
                    <textarea id="newposttext" class="row" name="postcontent" 
                                onfocus="clearContents(this);"
                                onblur="addContents(this)">What's on your mind...</textarea>
                    <input class="btn row col-2-sm" type="submit" value="Post">
                </form>
            </div>
        </div>
	</body>
</html>