<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT count(borrows.bornumber) as borrowCount, docuemnt.title, docuemnt.docid, YEAR(borrows.bdtime) as year
			FROM docuemnt, borrows
			WHERE borrows.docid = docuemnt.docid
			GROUP BY year, docuemnt.docid
			ORDER BY year DESC";

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





