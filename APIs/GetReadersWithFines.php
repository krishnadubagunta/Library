<?php 
	include('./APIconnect.php');

	$sql = "SELECT r.readerid, r.readername, 
					(SELECT SUM(DATEDIFF(b2.rdtime, b2.bdtime) - 20) * 0.20 as Fine
						FROM borrows as b2
						WHERE b2.readerid = r.readerid and (DATEDIFF(b2.rdtime, b2.bdtime) - 20) > 0
					) as Fine
        
			FROM readers as r, borrows as b
			WHERE r.readerid = b.readerid
			GROUP BY r.readerid";

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