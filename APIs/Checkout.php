<?php 
	include('./APIconnect.php');

	$docId = $_POST['docId'];
	$copyNo = $_POST['copyNo'];
	$libid = $_POST['libid'];
	$userid = $_POST['readerId'];

	$sql = "INSERT INTO `borrows` 
				(`bornumber`, `readerid`, `docid`, `copyno`, `libid`, `bdtime`, `rdtime`) 
			VALUES (NULL, '$userid', '$docId', '$copyNo', '$libid', CURRENT_TIME(), '');";

	$query = mysqli_query($conn, $sql);

	$sql = "DELETE FROM `reserve` WHERE docid = $docId and copyno = $copyNo and libid = $libid";

	$query = mysqli_query($conn, $sql);
	print_r($sql); 

 ?>