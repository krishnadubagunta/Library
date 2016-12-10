<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT count(borrows.docid) as amountBorrowed, docuemnt.title as docuemntTitle, branch.libid, branch.lname
			FROM branch, borrows, docuemnt
			WHERE branch.libid = borrows.libid and borrows.docid = docuemnt.docid
			GROUP BY borrows.docid, branch.libid, branch.lname
			ORDER BY branch.libid DESC, amountBorrowed DESC";

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





