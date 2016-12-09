<?php 
	include('./APIconnect.php');

	$id = $_POST['readerId'];

	$sql = "SELECT * 
			from reserve as res, readers as rea, docuemnt as d, branch as b, publisher as p
			where res.readerid = rea.readerid 
					and d.docid = res.docid 
			        and b.libid = res.libid
			        and p.publisherid = d.publisherid
			        and res.readerid = $id";

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