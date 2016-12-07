<?php 
	include('./APIconnect.php');

	$id = $_POST['readerID'];

	$sql = "SELECT *
			FROM readers 
			WHERE  readerid = $id and readertype = 'reader'";

	$results = mysqli_fetch_assoc($conn->query($sql));
	print json_encode($results);
?>