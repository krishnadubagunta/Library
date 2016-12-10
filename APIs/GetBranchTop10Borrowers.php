<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT count(readers.readerid) as booksOut, 
				   readers.readername, 
				   branch.libid, 
				   branch.lname
			FROM branch, readers, borrows
			WHERE branch.libid = borrows.libid and readers.readerid = borrows.readerid
			GROUP BY readers.readername, branch.libid, branch.lname
			ORDER BY branch.libid DESC, booksOut DESC";

	$results = mysqli_fetch_assoc($conn->query($sql));
	print json_encode($results);
?>





