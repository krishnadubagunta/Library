<?php 
	include('./APIconnect.php');

	$bornumber = $_POST['bornumber'];

	$sql = "UPDATE `borrows` SET `rdtime` = '".date('Y-m-d')."' WHERE `borrows`.`bornumber` = $bornumber;";

	$query = mysqli_query($conn, $sql);
	print_r($sql); 

 ?>

