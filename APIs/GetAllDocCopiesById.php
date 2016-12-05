<?php 
	include('./APIconnect.php');

	$id = $_POST['docid'];

	$sql = "SELECT * 
			FROM docuemnt 
				JOIN copy 
				JOIN branch 
			WHERE docuemnt.docid = copy.docid 
					and branch.libid = copy.libid
					and docuemnt.docid = $id";

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