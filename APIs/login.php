<?php 
	include('./APIconnect.php');

	$id = $_GET['id'];

	$sql = "SELECT * FROM readers WHERE readerid = $id";
	$results = mysqli_fetch_assoc($conn->query($sql));
	print json_encode($results);
?>