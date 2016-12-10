<?php 
	include('./APIconnect.php');

	$id = $_POST['readerid'];

	$sql = "SELECT *, IF(((DATEDIFF(b.rdtime, b.bdtime) - 20) * 0.20) > 0, ((DATEDIFF(b.rdtime, b.bdtime) - 20) * 0.20) , 0) as Fine 
		FROM readers as r, borrows as b, docuemnt as d
		WHERE r.readerid = b.readerid and r.readerid = $id and d.docid = b.docid";

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