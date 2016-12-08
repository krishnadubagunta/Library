<?php 
	include('./APIconnect.php');

	$bornumber = $_POST['bornumber'];

	$sql = "UPDATE `borrows` SET `rdtime` = CURRENT_TIME() WHERE `borrows`.`bornumber` = $bornumber;";

	$query = mysqli_query($conn, $sql);
	print_r($sql); 

 ?>

