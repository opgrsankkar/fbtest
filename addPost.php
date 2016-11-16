<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconn.php';

connect();
$post_time = (string)(microtime(true))*10000;
echo $post_time."<br>";
$curr_date_time = date("Y-m-d H:i:s");
$u_id=$_SESSION['user_id'];
$viewershipphp='friends';
$contents = $_POST['postcontent'];
if(trim($contents)!=''){
    header("Location: index.php");


$stmt = $conn->prepare("INSERT INTO post (post_id,user_id, add_date,content,viewership) VALUES(?, ?, ?, ?, ?)");
$stmt->bind_param("iisss",
    $post_time,
    $u_id, 
    $curr_date_time,
    $contents,
    $viewershipphp);

if ($stmt->execute() === TRUE) {
    echo "New Post added<br>";
} else {
	echo "Error<br>" . $conn->error;
}
}
// Upload Photos
echo isset($_FILES['uploaded']['tmp_name']);
echo "<br>";
if(isset($_FILES['uploaded']['tmp_name'][0])){
    echo count($_FILES['uploaded']['tmp_name'][0]).'<br>';
for($i = 0; $i < count($_FILES['uploaded']['tmp_name']); $i++){
    $target = "photos/";
    $t_stamp = (string)(microtime(true))*10000;
    $f_name = $t_stamp .'.'. end(explode(".", $_FILES['uploaded']['name'][$i]));
    $target = $target . $f_name;
    $uploaded_size = $_FILES['uploaded']['size'][$i];
    $ok=1;

    //This is our size condition
    if ($uploaded_size > 2097152){
    echo "Your file is too large. We have a 2MB limit.<br>";
    $ok=0;
    }

    $types = array('image/jpeg', 'image/gif', 'image/png');

    if (in_array($_FILES['uploaded']['type'][$i], $types)) {
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
    if(move_uploaded_file($_FILES['uploaded']['tmp_name'][$i], $target)){
        connect();
        $sql="INSERT INTO photos(photo_id,post_id,user_id,add_date,link,viewership) values (".
                    $t_stamp.",".
                    $post_time.",".
                    $u_id.",'".
                    date("Y-m-d H:i:s")."','".
                    $f_name."','".
                    $viewershipphp."');";
        if ($conn->query($sql) === TRUE) {
        echo "New Photo added";
        // header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        disconnect();
    echo "The file ". basename( $_FILES['uploaded']['name'][$i]). " has been uploaded";
    }
    else{
    echo "Sorry, there was a problem uploading your file.";
    }
    }
}
}
disconnect();
header("Location: index.php");
?>