<?php
include 'dbconn.php';
if(isset($_FILES['uploaded']['tmp_name'])){
    echo count($_FILES['uploaded']['tmp_name']).'<br>';
for($i = 0; $i < count($_FILES['uploaded']['tmp_name']); $i++){
    $target = "photos/";
    $f_name = (microtime(true))*10000 .'.'. end(explode(".", $_FILES['uploaded']['name'][$i]));
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
        $sql="INSERT INTO sample_upload(ph_id) values ('".$f_name."');";
        if ($conn->query($sql) === TRUE) {
        echo "New Photo added";
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
?>