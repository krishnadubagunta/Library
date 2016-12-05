<?php 
	include('./APIconnect.php');

	$id = $_POST['docid'];
	$title = $_POST['docTitle'];
	$publisher = $_POST['docPublisher'];

	$sql = "SELECT * 
			FROM docuemnt as d join publisher as p on d.publisherid = p.publisherid 
			WHERE 1=0 ";

	if ($id) {
		$sql = $sql . " or docid = $id ";
	}
	if ($title) {
		$sql = $sql . " or title LIKE '%$title%' ";
	}
	if ($publisher) {
		$sql = $sql . " or pubname LIKE '%$publisher%' ";
	}

	$jsonHack = false;

	$query = mysqli_query($conn, $sql);
	print_r("["); 
	while($row = mysqli_fetch_assoc($query)){
		if ($jsonHack) {print_r(",");}
		else{$jsonHack=true;}

	    print_r(json_encode($row));   
	}
	print_r("]"); 
?>