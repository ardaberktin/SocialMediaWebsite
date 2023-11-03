<?php

 // read json file into array of strings
 $jsonstring = file_get_contents("userprofiles.json");
 
 // save the json data as a PHP array
 $phparray = json_decode($jsonstring, true);
 
 // see results of decoded json into a php associative array
 //echo "<pre>";
 // var_dump($phparray);
 // echo "</pre>";
 
 // use GET to determine type of connection
 if (isset($_GET["connection"])){
  $connection = $_GET["connection"];
 } else {
  $connection = "all"; 
 }
 
  // pull public or private only or return all
  // NOTE: to make this more secure, if $connection == "private" or "all"
  // you would also check that an editor is logged in.
  $returnData = [];
  if ($connection != "all") { 
   foreach($phparray as $entry) {
    // var_dump($entry);
      if ($entry["connection"] == $connection) {
         $returnData[] = $entry;  
      }      
   } // foreach
  } else {
     $returnData = $phparray;
  }

// encode the php array to json 
 $jsoncode = json_encode($returnData, JSON_PRETTY_PRINT);
 echo ($jsoncode);



?>