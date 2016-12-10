<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT count(readers.readerid) as booksOut, 
				   readers.readername, 
				   branch.libid, 
				   branch.lname,
				   readers.readerid
			FROM branch, readers, borrows
			WHERE branch.libid = borrows.libid and readers.readerid = borrows.readerid
			GROUP BY readers.readername, branch.libid, branch.lname
			ORDER BY branch.libid DESC, booksOut DESC";

	$jsonHack = false;

	$query = mysqli_query($conn, $sql);
	print_r("["); 
	while($row = mysqli_fetch_assoc($query)){
		if ($jsonHack) {print_r(",");}
		else{$jsonHack=true;}

	    print_r(json_encode($row) or '{c:"s"}');   
	}
	print_r("]"); 
?>





