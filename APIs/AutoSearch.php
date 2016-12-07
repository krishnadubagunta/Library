<?php 
	include('./APIconnect.php');

	$search = $_POST['searchTerm'];

	$sql = "SELECT * 
			FROM docuemnt as d join publisher as p on d.publisherid = p.publisherid 
			WHERE docid = '$search'  or title LIKE '%$search%' or pubname LIKE '%$search%' ";

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