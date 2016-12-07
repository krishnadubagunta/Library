<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT *
			FROM reader 
			WHERE  id = $id and readertype = 'admin' and password = $password";

	$results = mysqli_fetch_assoc($conn->query($sql));
	print json_encode($results);
?>