

<div id="feedNav" class="nav">
	<a href="?page=post">Post Pic</a>
	<a href="?page=home">Users</a>
	<a href="?page=login">Sign Out</a>
</div>

<br><br><br><br>
<h1>Feed</h1>

<div id="bigBox">



<?php 
if (file_exists("posts.json")){
	$file = "userprofiles.json";
	$jsonstring = file_get_contents($file);	
	$phparray = json_decode($jsonstring, true);

	$profilestring = file_get_contents("posts.json");	
	$postsarray = json_decode($profilestring, true);

	$caption = "";

	for ($x = 0; $x < count($phparray); $x++){



	$dir = "profiles/" . $phparray[$x]["name"] . "/" ;
	$folderName = '"' . $dir . '"';
	$username =  '"' . $phparray[$x]["name"] . '"';
	$username2 = $phparray[$x]["name"];

		// Open a directory, and read its contents
		if (is_dir($dir)){
		  if ($dh = opendir($dir)){
			$counter = 1;
			while (($file = readdir($dh)) !== false){
				if ($file != ".." && $file != ".") {
					
					$postImage = $dir . $file;
			
					$name = '"' . $counter . '"';
					$filename = '"' . $file . '"';
					
					for($k = 0; $k < count($postsarray); $k++) {
						if($username2 == $postsarray[$k]["username"]){
							if (substr($file, 0, 1) == $postsarray[$k]["UID"]){
								$caption = $postsarray[$k]["description"];
							}
						}
					}
					
					echo 
					"
						<div class='cards'> 
						
						<div id=$name class='postUser' onclick='gotoProfile($username)'>$username2</div>
						
							<img class='post' onclick='displayLightBox($name, $filename, $folderName)'src='$postImage' >
						
						<div class='postInfo'>$caption</div>
						
						</div>";
					$counter ++;
				} 
			}
			closedir($dh);
		  }
		}
	}
}
?>
	
	</div>

	<div id='lightbox' class='hidden'>
	</div>

	<div id="positionBigImage" class="hidden">
	  <div id="boundaryBigImage">
		<img id="x" src="images/x.png" alt="close" onclick="displayLightBox('', '')">
		<img id="bigImage" src="profiles/Sadikshya/1.jpg" alt="6">
		
		<a href="#" download="image" id="download">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<button class="btn" style="width:100%"><i class="fa fa-download"></i> Download</button>
		</a><br><br>

	  <div id="displayName" class="displayInfo"></div>
	  <div id="displayDescription" class="displayInfo"></div>

	  </div>
	</div>