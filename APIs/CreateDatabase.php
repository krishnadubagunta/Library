<?php 
	include('./connect.php');

	$sql = "DROP DATABASE IF EXISTS CS631";
	if ($conn->query($sql) === TRUE) {echo "Database removed successfully<br/>";} 
	else {echo "Error creating database: " . $conn->error . "<br/>";}


	//-------Create database-----
	$sql = "CREATE DATABASE IF NOT EXISTS CS631";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully<br/>";
	} else {
	    echo "Error creating database: " . $conn->error . "<br/>";
	}

	$conn = new mysqli($servername, $username, $password, 'CS631');


	// -------CREATE READER TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS readers 
			( 	readerid 	INT NOT NULL AUTO_INCREMENT , 
				readertype 	VARCHAR(255) NOT NULL , 
				readername 	VARCHAR(255) NOT NULL , 
				address 	VARCHAR(255) NOT NULL ,

				PRIMARY KEY (`readerid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table READER created successfully<br/>";
	} else {
	    echo "Error creating table READER: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE PUBLISHER TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS publisher 
			( 	publisherid INT NOT NULL AUTO_INCREMENT , 
				pubname 	VARCHAR(255) NOT NULL , 
				address 	VARCHAR(255) NOT NULL, 

				PRIMARY KEY (`publisherid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table PUBLISHER created successfully<br/>";
	} else {
	    echo "Error creating table PUBLISHER: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE BRANCH TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS branch 
			( 	libid 		INT NOT NULL AUTO_INCREMENT , 
				lname 		VARCHAR(255) NOT NULL , 
				llocation 	VARCHAR(255) NOT NULL, 

				PRIMARY KEY (`libid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table BRANCH created successfully<br/>";
	} else {
	    echo "Error creating table BRANCH: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE DOCUMENT TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS docuemnt 
			( 	docid 		INT NOT NULL AUTO_INCREMENT , 
				title 		VARCHAR(255) NOT NULL , 
				pdate		DATE NOT NULL,
				publisherid INT NOT NULL,

				INDEX pub_index (publisherid),
			    FOREIGN KEY (publisherid)
			        REFERENCES publisher(publisherid)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table DOCUMENT created successfully<br/>";
	} else {
	    echo "Error creating table DOCUMENT: " . $conn->error . "<br/>";
	}
	//----------------END-------------

	// -------CREATE COPY TABLE----
	$sql = "CREATE TABLE IF NOT EXISTS copy 
			( 	docid 		INT NOT NULL , 
				copyno 		INT NOT NULL , 
				libid       INT NOT NULL,
				possition   VARCHAR(255) NOT NULL,

				INDEX docid_index (docid),
				INDEX libid_index (libid),

			    FOREIGN KEY (docid)
			        REFERENCES docuemnt(docid)
			        ON DELETE CASCADE,

			    FOREIGN KEY (libid)
			        REFERENCES branch(libid)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`,`copyno`,`libid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table COPY created successfully<br/>";
	} else {
	    echo "Error creating table COPY: " . $conn->error . "<br/>";
	}
	//----------------END-------------



	// -------CREATE BORROWS TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS borrows 
			( 	bornumber 	INT NOT NULL AUTO_INCREMENT , 
				readerid 	INT NOT NULL, 
				docid		INT NOT NULL,
				copyno  	INT NOT NULL,
				libid   	INT NOT NULL,
				bdtime		DATETIME NOT NULL,
				rdtime		DATETIME NOT NULL,

				INDEX reader_index (readerid),
				INDEX copy_index (docid,copyno,libid),

			    FOREIGN KEY (docid,copyno,libid)
			        REFERENCES copy(docid,copyno,libid)
			        ON DELETE CASCADE,

			    FOREIGN KEY (readerid)
			        REFERENCES readers(readerid)
			        ON DELETE CASCADE,

				INDEX doc_index (docid,copyno,libid),

				PRIMARY KEY (`bornumber`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table BORROWS created successfully<br/>";
	} else {
	    echo "Error creating table BORROWS: " . $conn->error . "<br/>";
	}
	//----------------END-------------

		// -------CREATE RESERVE TABLE----
	$sql = "CREATE TABLE  IF NOT EXISTS reserve 
			( 	resnumber 	INT NOT NULL AUTO_INCREMENT , 
				readerid 	INT NOT NULL, 
				docid		INT NOT NULL,
				copyno  	INT NOT NULL,
				libid   	INT NOT NULL,
				dtime		DATETIME NOT NULL,

				INDEX reader_index (readerid),
				INDEX copy_index (docid,copyno,libid),

			    FOREIGN KEY (docid,copyno,libid)
			        REFERENCES copy(docid,copyno,libid)
			        ON DELETE CASCADE,

			    FOREIGN KEY (readerid)
			        REFERENCES readers(readerid)
			        ON DELETE CASCADE,

				INDEX doc_index (docid,copyno,libid),

				PRIMARY KEY (`resnumber`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table RESERVE created successfully<br/>";
	} else {
	    echo "Error creating table RESERVE: " . $conn->error . "<br/>";
	}
	//----------------END-------------


 ?>