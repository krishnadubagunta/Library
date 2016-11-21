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

	// -------CREATE READER AUTHOR----
	$sql = "CREATE TABLE  IF NOT EXISTS author 
			( 	authorid 	INT NOT NULL AUTO_INCREMENT , 
				aname 		VARCHAR(255) NOT NULL , 

				PRIMARY KEY (`authorid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table AUTHOR created successfully<br/>";
	} else {
	    echo "Error creating table AUTHOR: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE TABLE BOOK----
	$sql = "CREATE TABLE IF NOT EXISTS book 
			( 	docid 		INT NOT NULL , 
				ISBN   		VARCHAR(255) not null,

				INDEX docid_index (docid),


			    FOREIGN KEY (docid)
			        REFERENCES docuemnt(docid)
			        ON DELETE CASCADE,

			PRIMARY KEY (`docid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table BOOK created successfully<br/>";
	} else {
	    echo "Error creating table BOOK: " . $conn->error . "<br/>";
	}
	//----------------END-------------

	// -------CREATE TABLE WRITES----
	$sql = "CREATE TABLE  IF NOT EXISTS writes 
			( 	authorid 	INT NOT NULL , 
				docid 		INT NOT NULL , 

				INDEX auth_index (authorid),
				INDEX doc_index (docid),

			    FOREIGN KEY (authorid)
			        REFERENCES author(authorid)
			        ON DELETE CASCADE,

			    FOREIGN KEY (docid)
			        REFERENCES book(docid)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`,`authorid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table WRITES created successfully<br/>";
	} else {
	    echo "Error creating table WRITES: " . $conn->error . "<br/>";
	}
	//----------------END-------------

	// -------CREATE TABLE PROCEEDINGS----
	$sql = "CREATE TABLE IF NOT EXISTS proceesings 
			( 	docid 		INT NOT NULL , 
				cdate       DATE not null,
				clocation   VARCHAR(255) not null,
				ceditor 	VARCHAR(255) not null,

				INDEX docid_index (docid),


			    FOREIGN KEY (docid)
			        REFERENCES docuemnt(docid)
			        ON DELETE CASCADE,

			PRIMARY KEY (`docid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table PROCEEDINGS created successfully<br/>";
	} else {
	    echo "Error creating table PROCEEDINGS: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE READER CHIEF EDITOR----
	$sql = "CREATE TABLE  IF NOT EXISTS chief_editor 
			( 	editorid 	INT NOT NULL AUTO_INCREMENT, 
				ename 		VARCHAR(255) NOT NULL, 

				PRIMARY KEY (`editorid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table CHIEF EDITOR created successfully<br/>";
	} else {
	    echo "Error creating table CHIEF EDITOR: " . $conn->error . "<br/>";
	}
	//----------------END-------------

	// -------CREATE TABLE JOURNAL_VOLUME----
	$sql = "CREATE TABLE IF NOT EXISTS journal_volume 
			( 	docid 		INT NOT NULL, 
				jvolume     INT NOT NULL,
				editorid    INT NOT NULL,

				INDEX docid_index (docid),
				INDEX editor_index (editorid),


			    FOREIGN KEY (docid)
			        REFERENCES docuemnt(docid)
			        ON DELETE CASCADE,  

			    FOREIGN KEY (editorid)
			        REFERENCES chief_editor(editorid)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table JOURNAL_VOLUME created successfully<br/>";
	} else {
	    echo "Error creating table JOURNAL_VOLUME: " . $conn->error . "<br/>";
	}
	//----------------END-------------

	// -------CREATE READER JOURNAL_ISSUE----
	$sql = "CREATE TABLE  IF NOT EXISTS journal_issue 
			( 	docid 		INT NOT NULL,
				issue_no 	INT NOT NULL,
				scope 		VARCHAR(255) NOT NULL, 

				INDEX docid_index (docid),
				FOREIGN KEY (docid)
			        REFERENCES journal_volume(docid)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`,`issue_no`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table JOURNAL_ISSUE created successfully<br/>";
	} else {
	    echo "Error creating table JOURNAL_ISSUE: " . $conn->error . "<br/>";
	}
	//----------------END-------------


	// -------CREATE READER INV_EDITOR----
	$sql = "CREATE TABLE  IF NOT EXISTS inv_editor 
			( 	docid 		INT NOT NULL,
				issue_no 	INT NOT NULL,
				iename 		VARCHAR(255) NOT NULL, 

				INDEX docid_index (docid,issue_no),
				FOREIGN KEY (docid,issue_no)
			        REFERENCES journal_issue(docid,issue_no)
			        ON DELETE CASCADE,

				PRIMARY KEY (`docid`,`issue_no`,`iename`)) 
				ENGINE = InnoDB;";

	if ($conn->query($sql) === TRUE) {
	    echo "Table INV_EDITOR created successfully<br/>";
	} else {
	    echo "Error creating table INV_EDITOR: " . $conn->error . "<br/>";
	}
	//----------------END-------------
 ?>