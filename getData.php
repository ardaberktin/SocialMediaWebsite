<?php

$UID = htmlspecialchars($_GET["uid"]);

if (file_exists("userprofiles.json")) {
	
	// read json file into array of strings
	$file = "userprofiles.json";
	$jsonstring = file_get_contents($file);

	//decode the string from json to PHP array
	$phparray = json_decode($jsonstring, true);
	 
} // if

for ($x = 0; $x < count($phparray); $x++) {

    $num = $phparray[$x]["UID"];

    if ($num == $UID) {
    	echo json_encode($phparray[$x]);
	}
}

?>