<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
include 'dbconn.php';

connect();
$sql = "SELECT USER_ID,FNAME,LNAME,EMAIL,DOB FROM USERS WHERE EMAIL='".$_POST['email']."' AND PASSWORD='".$_POST['pass']."';";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id']=$row['USER_ID'];
    $_SESSION['fname']=$row['FNAME'];
    $_SESSION['lname']=$row['LNAME'];
    $_SESSION['email']=$row['EMAIL'];
    $_SESSION['dob']=$row['DOB'];
    header('Location: index.php');
}
else {
    echo '<p>Login Failed.<br>Incorrect Username/Password</p>';
    echo '<p><a href="login.php?e='.$_POST['email'].'">Try Again</a></p>';
    echo '<p><a href="register.html">Create new Account?</a></p>';
}

disconnect();
?>