<?php 

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

// -------CREATE READERers----	
for ($x = 0; $x <= 50; $x++) {
	$sql = "INSERT INTO readers 
			(readername, readertype, address)
			VALUES ('".generateRandomString(5)."', 'admin', '".generateRandomString(20)."')";
	$conn->query($sql);

	$sql = "INSERT INTO readers 
			(readername, readertype, address)
			VALUES ('".generateRandomString(5)."', 'student', '".generateRandomString(20)."')";
	$conn->query($sql);	
}
echo "100 NEW reader instered<br/>"; 
//----------------END-------------

?>