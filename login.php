<?php
session_start();
include 'dbconn.php';

connect();
$sql = "SELECT fname,lname,email,dob FROM users where email='".$_POST['email']."' and password='".$_POST['pass']."';";
echo '<p>'.$sql.'</p>';
$result = $conn->query($sql);


if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['fname']=$row['fname'];
    $_SESSION['lname']=$row['lname'];
    $_SESSION['email']=$row['email'];
    $_SESSION['dob']=$row['dob'];
    header('Location: index.php');
}
else {
    echo '<p>Login Failed</p>';
    echo '<p><a href="register.html">Create new Account?</a></p>';
}

disconnect();
?>