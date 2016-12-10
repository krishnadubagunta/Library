<?php 
	include('./APIconnect.php');

	$sql = "SELECT * FROM branch";

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