<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if (array_key_exists("fname",$_SESSION))
        if(empty($_SESSION['fname']))
            {header('Location:index.php');}
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
	</head>
	<body>
        <nav class="row">
            <span class="col-1-sm"></span>
            <span class="col-2-sm">F.R.I.E.N.D.S</span>
        </nav>
		<div id="logindiv" >
            <div class="row empty-row"></div>
			<form id="loginform" method="post" action="loginprocess.php">
                        <div id="emaildiv" class="row">
                                <span class="col-8"></span>
                                <label id="emaillabel" for="email" class="col-1">Email</label>
								<input id="email" class="col-2" type="text" name="email">
						</div>
                        <div id="passdiv" class="row">
                                <span class="col-8"></span>
                                <label id="passlabel" for="pass" class="col-1">Password</label>
								<input id="pass" class="col-2" type="password" name="pass">
						</div>
                        <div class="row">
                            <span class="col-5"></span>
						    <button class="btn col-2" type="submit">Login</button>
                            <a class="col-1" href="register.html" title="Signup for F.R.I.E.N.D.S">Signup</a>
                        </div>
			</form>
		</div>
	</body>
</html>
