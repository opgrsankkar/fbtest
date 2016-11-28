<?php
include 'dbconn.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	if($_SESSION['fname']==''){header('Location:login.php');}
}
$user_id = $_SESSION['user_id'];

if(isset($_FILES['dp_upload']['tmp_name'])){
    echo count($_FILES['dp_upload']['tmp_name']).'<br>';
    $target = "photos/";
    $f_name = $user_id .'.'. end(explode(".", $_FILES['dp_upload']['name']));
    $target = $target . $f_name;
    $uploaded_size = $_FILES['dp_upload']['size'];
    $ok=1;

    //This is our size condition
    if ($uploaded_size > 2097152){
    echo "Your file is too large. We have a 2MB limit.<br>";
    ?><script>alert("Your file is too large. We have a 2MB limit")</script><?php
    $ok=0;
    }

    $types = array('image/jpeg', 'image/gif', 'image/png');

    if (in_array($_FILES['dp_upload']['type'], $types)) {
    // file is okay continue
    } else {
    $ok=0;
    } 

    //Here we check that $ok was not set to 0 by an error
    if ($ok==0){
    Echo "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
    }

    //If everything is ok we try to upload it
    else{
    if(move_uploaded_file($_FILES['dp_upload']['tmp_name'], $target)){
        connect();
        $sql="UPDATE USERS SET DP='$f_name' WHERE USER_ID=$user_id;";
        if ($conn->query($sql) === TRUE) {
        echo "New Photo added";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        disconnect();
    echo "The file ". basename( $_FILES['dp_upload']['name']). " has been uploaded";
    }
    else{
    echo "Sorry, there was a problem uploading your file.";
    }
    }
    if($ok=1){header('Location: posts.php?v_id='.$user_id);}
}
?>