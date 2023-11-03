<button onclick="window.location.href='?page=feed'">Back</button><br><br>

<div id="bigBox">
<?php 

	$name = substr($_GET["page"], 13);

	$file = "userprofiles.json";
	$jsonstring = file_get_contents($file);	
	$phparray = json_decode($jsonstring, true);
	
	$file2 = "posts.json";
	$string = file_get_contents($file2);	
	$postarray = json_decode($string, true);
	
	$dir = "thumbnails/";

	for ($x = 0; $x < count($phparray); $x++){
		
		if ($phparray[$x]["name"] == $name) {
			
			$target_dir = "profiles/" . $phparray[$x]['name'] . "/";
			$imagetype = $phparray[$x]['imagetype'];
			
			$photoAmount = count($postarray);
			
			echo "
			<div class='profileImages'> 
			<img id='img'src='thumbnails/" . $x + 1 . "." . $imagetype . "'></img><br>
			</div>
			";	
			
			echo "<b>" . $phparray[$x]['name'] . "</b><br>";	
			echo $phparray[$x]['description']  . "<br>";
			
			for ($k = 0; $k < $photoAmount; $k++){
				if ($postarray[$k]["username"] == $phparray[$x]["name"]){
					echo "
					
					<div class='cards'> 
					<img  src='profiles/" . $phparray[$x]['name'] . "/" . $postarray[$k]['UID'] . "." . $postarray[$k]["imagetype"] . "'></img>
					</div>
					
					";	
				}
			}
		}
	} // else 
?>
</div>