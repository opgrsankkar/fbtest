<?php
include 'dbconn.php';

connect();

$sql = 'SELECT NAME,PASS FROM USERS';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "id: ".$row['NAME']." - Password: ".$row['PASS']."<br />";
	}
}
else {
	echo "0 result";
}

disconnect();
?>