<?php 
	include('./APIconnect.php');

	$id = $_POST['readerId'];

	$sql = "SELECT *
			FROM reader 
			WHERE  id = $id and readertype = 'reader'";

	$results = mysqli_fetch_assoc($conn->query($sql));
	print json_encode($results);
?>