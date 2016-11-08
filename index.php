<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.html');}
}
echo '<!DOCTYPE html>';
echo '<html>';
echo	'<head>';
echo		'<meta charset="utf-8">';
echo		'<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo		'<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo		'</echo><link rel="stylesheet" type="text/css" href="simple-grid.css">';
echo        '<link rel="stylesheet" type="text/css" href="main.css">';
echo	'</head>';
echo	'<body>';
echo		'<nav class="row">';
echo            '<span class="col-1-sm"></span>';
echo            '<span class="col-2-sm">F.R.I.E.N.D.S</span>';
echo        '</nav>';
echo		'<div class="sidenav">';
echo			'<p>Hi, '.$_SESSION['fname'].'</p>';
echo		'</div>';
echo	'</body>';
echo'</html>';
