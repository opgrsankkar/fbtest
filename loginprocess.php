<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
include 'dbconn.php';

connect();
$sql = "SELECT user_id,fname,lname,email,dob FROM users where email='".$_POST['email']."' and password='".$_POST['pass']."';";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id']=$row['user_id'];
    $_SESSION['fname']=$row['fname'];
    $_SESSION['lname']=$row['lname'];
    $_SESSION['email']=$row['email'];
    $_SESSION['dob']=$row['dob'];
    header('Location: index.php');
}
else {
    echo '<p>Login Failed.<br>Incorrect Username/Password</p>';
    echo '<p><a href="login.php?e='.$_POST['email'].'">Try Again</a></p>';
    echo '<p><a href="register.html">Create new Account?</a></p>';
}

disconnect();
?>