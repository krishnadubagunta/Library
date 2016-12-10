<?php 
	include('./APIconnect.php');

	$id = $_POST['adminId'];
	$password = $_POST['password'];

	$sql = "SELECT count(borrows.bornumber) as borrowCount, docuemnt.title, docuemnt.docid, YEAR(borrows.bdtime) as year
			FROM docuemnt, borrows
			WHERE borrows.docid = docuemnt.docid
			GROUP BY year, docuemnt.docid
			ORDER BY year DESC";

	$query = mysqli_query($conn, $sql);

	$rows = array();
	while($r = mysqli_fetch_assoc($query)) {
	    $rows[] = $r;
	}
	print json_encode($rows);
?>





