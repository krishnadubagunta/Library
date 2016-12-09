<?php 
	include('./APIconnect.php');

	$docName = $_POST['docName'];
	$publishDate = $_POST['publishDate'];
	$publisherID = $_POST['publisherID'];


	$sql = "INSERT INTO `docuemnt` 
			(`docid`, `title`, `pdate`, `publisherid`) 
			VALUES (NULL, '$docName', '$publisherID', '$publisherID')";

	$query = mysqli_query($conn, $sql);

	print_r($sql); 

 ?>