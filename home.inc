<div id="userNav" class="nav">
	<a href="?page=feed">Feed</a>
	<a href="?page=login">Sign Out</a>
</div>

<br><br><br>
<h1>Users</h1>


<a href="downloadall.php" download><button>Download Profile Images</button></a><br><br>

<!--<a href = "index.php?deleteAll=true">Reset Gallery</a><br>-->

<form>
  <label for="connection">Connection to Mount Doug:</label>
  <select name="connection" id="connection" onchange="{loadImages();if(this.options[this.selectedIndex].onclick != null){this.options[this.selectedIndex].onclick(this);}}">
    <option onclick="loadImages('all')">Show all</option>
    <option onclick="loadImages('currentStudent')">Student Images</option>
    <option onclick="loadImages('staff')">Staff Images</option>
    <option onclick="loadImages('alumni')">Alumni Images</option>
  </select>
</form>


<div id="bigBox">
<?php 
	 
	$dir = "thumbnails/";

	// Open a directory, and read its contents
	if (is_dir($dir)){
	  if ($dh = opendir($dir)){
	  	$counter = 1;
		while (($file = readdir($dh)) !== false){
			if ($file != ".." && $file != ".") {
				$thumbImage = "thumbnails/" . $file;
				//$originalImage = "profileimages/" . $file;
				$name = '"' . $counter . '"';
				$filename = '"' . $file . '"';
				$folder = '"profileimages/"';
				$id = '"displayName' . $counter . '"';
				echo 
				"
				    
					<div class='cards'> 
						
					<label id=$id class='displayInfo' onclick='gotoProfile2($filename)'></label> <br>
					<img class='thumb' onload='displayInfo($name, $filename, $id)' src='$thumbImage' alt=$name>
			


					</div>
					";
					$counter ++;
			} 
		}
		closedir($dh);
	  }
	}

?>
	</div>

