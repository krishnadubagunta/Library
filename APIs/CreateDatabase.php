<?php 
	include('./connect.php');

	// Create database
	$sql = "CREATE DATABASE CS631";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully<br/>";
	} else {
	    echo "Error creating database: " . $conn->error . "<br/>";
	}

	$conn = new mysqli($servername, $username, $password, 'CS631');

	// sql to create table
	$sql = "CREATE TABLE MyGuests (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
	    echo "Table MyGuests created successfully<br/>";
	} else {
	    echo "Error creating table: " . $conn->error . "<br/>";
	}

 ?>