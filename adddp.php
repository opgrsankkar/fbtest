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
        function click(){
            document.getElementById('autoClick').click();
        }
    </script>
</head>
<body onload="click()">
    <form method="POST" action="uploaddp.php" enctype="multipart/form-data">
        <input type="file" id="dp_upload" name="dp_upload" />
        <input type="submit" value="Upload"/>
    </form>
</body>
</html>