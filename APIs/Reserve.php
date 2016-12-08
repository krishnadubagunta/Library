<?php 
	include('./APIconnect.php');

	$docId = $_POST['docId'];
	$copyNo = $_POST['copyNo'];
	$libid = $_POST['libid'];
	$userid = $_POST['readerId'];

	$sql = "INSERT INTO `reserve` 
				(`resnumber`, `readerid`, `docid`, `copyno`, `libid`, `dtime`) 
			VALUES (NULL, '$userid', '$docId', '$copyNo', '$libid', CURRENT_TIME());";

	$query = mysqli_query($conn, $sql);
	print_r($sql); 

 ?>