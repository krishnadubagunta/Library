<?php 
	include('./APIconnect.php');

	$readername = $_POST['readName'];
	$address = $_POST['readAddress'];

	$sql = "INSERT INTO `readers` (`readerid`, `readertype`, `readername`, `address`, `password`) VALUES (NULL, 'reader', '$readername', '$address', NULL)";

	$query = mysqli_query($conn, $sql);
	print_r($sql); 

 ?>