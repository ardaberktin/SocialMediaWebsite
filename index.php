<?php
/*******
* Name: Sadikshya Baral
* Program: RamFinal
* Date: June 6, 2022
* Purpose: add posting 
******/

session_start();

// include thumbnail code
include  "createthumbnail.php";

// variables 
$name = "";
$grade = "";
$consent = "";
$connection = "";
$description = "";

$nameErr = "";
$consentErr = "";
$descriptionErr = "";
$connectionErr = "";
$gradeErr = "";
$filenameErr = "";
$usernameErr = "";
$postPicErr = "";
$captionErr = "";

$newName = "";
$oldName = "";

$error = false;
$submit = false;
$uploadOk = true;
$checkProfilepic = false;

$target_dir = "profileimages/";

$dest = "";

if (!isset($_SESSION['myName'])){
	$_SESSION["myName"] = "";
}


// get the page 
if (isset($_GET["page"])){
   $page = $_GET["page"];
} else {
   $page = "login";
}

// delete the json file 
if (isset($_GET["deleteAll"]) && file_exists("userprofiles.json")) {
  unlink("userprofiles.json");
}

// delete the json file 
if (isset($_GET["deleteAll"]) && file_exists("posts.json")) {
  unlink("posts.json");
}

// deleting the images 
$dir = "profileimages/";
if (isset($_GET["deleteAll"])) {  
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      @unlink($dir . $file);
    } // while
  closedir($dh);
  } // if
} // if

// deleting the thumbnails 
if (isset($_GET["deleteAll"])) {  
  if ($dh = opendir("thumbnails/")){
    while (($file = readdir($dh)) !== false){
      @unlink("thumbnails/" . $file);
    } // while
  closedir($dh);
  } // if
} // if

// deleting the accounts 
if (isset($_GET["deleteAll"])) {  
  deleteAll("profiles/");
} // if

// delete all files and sub-folders from a folder
function deleteAll($dir) {
	foreach(glob($dir . '/*') as $file) {
		if(is_dir($file)){
			deleteAll($file);
		}
		else{
			unlink($file);
		}
	}
	rmdir($dir);
}

//------------------------------------
if (!file_exists("userprofiles.json")) {
	$file = fopen("userprofiles.json", "w");
} 

 // clean the data of the sumbitted form and error check 
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
	
	//------------------------------------
	if(isset($_POST["addProfile"])){
		
		  // create profiles if it doesn't exist
		  if (!is_dir("profiles/")) {
			  mkdir("profiles/"); 
			  //echo "<br>" . "profiles/" . " created!<br>";
		  } // if 
		
		  // create profileimages if it doesn't exist
		  if (!is_dir($target_dir)) {
			  mkdir($target_dir); 
			  //echo "<br>" . $target_dir . " created!<br>";
		  } // if 
		  
		  if (!file_exists("identifier.txt")) {
				$file = fopen("identifier.txt", "w");
		  }
		  
		  // checking for empty fields 
		  if (empty($_POST["name"])) {
				$nameErr = "* name is required";
				$error = true;
		  } else {
				$name = test_input($_POST["name"]);
		  } // if
		  
		  if(empty(basename($_FILES["filename"]["name"]))){
			  $filenameErr = "* profle pic is required";
			  $error = true;
		  } else {
			  $checkProfilepic = true;
			  $target_file = $target_dir . basename($_FILES["filename"]["name"]);
		  	  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		  }		  
		  
		  if (empty($_POST["description"])) {
			  $descriptionErr = "* description is required";
			  $error = true;
		  } else {
			  $description = test_input($_POST["description"]);
		  } // if

		  if (empty($_POST["consent"])) {
			  $consentErr = "* consent is required";
			  $error = true;
		  } else {
			  $consent = test_input($_POST["consent"]);
		  } // if

		  if (empty($_POST["connection"])) {
			  $connectionErr = "* connection is required";
			  $error = true;
		  } else { 
			
			  $connection = test_input($_POST["connection"]);
			
			  if ($connection == "currentStudent" && empty($_POST["grade"])) {
				  $gradeErr = "* grade is required";
				  $error = true;
			  } else if (!empty($_POST["grade"])){
				  $grade = test_input($_POST["grade"]);
			  } // else if
			
		  } // else
		  
		  // check if file is valid if file is submitted 
	    if ($checkProfilepic == true) {
		// Check if file already exists
			  if (file_exists($target_file)) {
				  $filenameErr = "Sorry, file already exists.";
				  $uploadOk = false;
				//  $error = true;
			  }
			  
			  // Check if image file is a actual image or fake image
			  if(isset($_POST["submit"])) {
				  $check = getimagesize($_FILES["filename"]["tmp_name"]);
				  if($check !== false) {
					  //echo "File is an image - " . $check["mime"] . ".";
					  $uploadOk = true;
				  } else {
					  $filenameErr = "File is not an image.";
					  $uploadOk = false;
					//  $error = true;
				  }
			  } // if
			  
			  // Check file size
			  if ($_FILES["filename"]["size"] > 4000000) {
				  $filenameErr = "Sorry, your file is too large.";
				  $uploadOk = false;
				 // $error = true;
			  }
			  
			  // Allow certain file formats
			  if($imageFileType != "jpg" && $imageFileType != "png") {
				  $filenameErr = "Sorry, only JPG & PNG files are allowed.";
				  $uploadOk = false;
				 // $error = true;
			  } // if
			  
			  // Check if $uploadOk is set to false by an error
			  if ($uploadOk == false) {
				  // $filenameErr = "Sorry, your file was not uploaded.";
				  $error = true;
				  
			  // if everything is ok, try to upload file
			  } else {
				  
					$target_file = $target_dir . basename($_FILES["filename"]["name"]);
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				  
					if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
					  $checkFile = false;
					 // echo "The file ". htmlspecialchars(basename($_FILES["filename"]["name"])). " has been uploaded.";
			 
					  // get the next UID for the next image 
					  $dir = "profileimages/";
					  file_put_contents("identifier.txt", count(scandir($dir)) - 2);

					  // change the name of the image
					  $oldName = basename($_FILES["filename"]["name"]);
					  $newName = file_get_contents("identifier.txt"). "." . $imageFileType;
					  rename("profileimages/" . $oldName, "profileimages/" . $newName);

					} else {
					  $filenameErr = "Sorry, there was an error uploading your file.";
					  $error = true;
					} 

			  }	// else
			  
		  } // if  

		  if ($error == true) {
			  $page = "form";
		  } else {
	  	   // create profiles if it doesn't exist
	  	   if (!is_dir("profiles/" . $name)) {
	  	 	  mkdir("profiles/" . $name); 
	  	 	  //echo "<br>" . $name . " created!<br>";
	  	   } // if
		  }
		  
	  $submit = true;
	  
	}
	//------------------------------------
	else if(isset($_POST["LogIn"])){
		
		
		if (filesize("userprofiles.json") != 0){
			
			$file = "userprofiles.json";
			$jsonstring = file_get_contents($file);	
			$phparray = json_decode($jsonstring, true);
			
			
			for ($x = 0; $x < count($phparray); $x++){

				if ($phparray[$x]["name"] == $_POST["username"]) {
					
					$_SESSION["myUID"] = $phparray[$x]["UID"];
					$_SESSION["myName"] = $phparray[$x]["name"];
					
					$page = "feed";
					break;

				}else {
					$usernameErr = "user does not exist";
					$page = "login";
				} // else 

			} // for
			
		} else {
			$usernameErr = "file is empty";
		}
		
	} // else 

	// ---------------------------------
	else if(isset($_POST["postPic"])){
		$uploadOk = true;
		$error = false;
		$folder = "profiles/" . $_SESSION["myName"] . "/";


		 if(empty(basename($_FILES["filename"]["name"]))){
			  $postPicErr = "* pic is required";
			  $error = true;
		  } else {
			
				$target_file = $folder . basename($_FILES["filename"]["name"]);
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
				// Check if file already exists
			  if (file_exists($target_file)) {
				  $postPicErr = "Sorry, file already exists.";
				  $uploadOk = false;
			  }
			  
			  // Check if image file is a actual image or fake image
			  if(isset($_POST["submit"])) {
				  $check = getimagesize($_FILES["filename"]["tmp_name"]);
				  if($check !== false) {
					  //echo "File is an image - " . $check["mime"] . ".";
					  $uploadOk = true;
				  } else {
					  $postPicErr = "File is not an image.";
					  $uploadOk = false;
				  }
			  } // if
			  
			  // Check file size
			  if ($_FILES["filename"]["size"] > 4000000) {
				  $postPicErr = "Sorry, your file is too large.";
				  $uploadOk = false;
				 // $error = true;
			  }
			  
			  // Allow certain file formats
			  if($imageFileType != "jpg" && $imageFileType != "png") {
				  $postPicErr = "Sorry, only JPG & PNG files are allowed.";
				  $uploadOk = false;
			  } // if						

			  // Check if $uploadOk is set to false by an error
			  if ($uploadOk == false) {
				  //$filenameErr = "Sorry, your file was not uploaded.";
				  $error = true;
				  
			  // if everything is ok, try to upload file
			  } else {
					if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
					  $checkFile = false;

					  // get the next UID for the next image 
					  $dir = $folder;
					  file_put_contents("identifier.txt", count(scandir($dir)) - 2);

					  // change the name of the image
					  $oldName = basename($_FILES["filename"]["name"]);
					  $newName = file_get_contents("identifier.txt"). "." . $imageFileType;
					  rename($folder . $oldName, $folder . $newName);
					} // if
					
					$src = $folder . $newName;
					createThumbnail($src, $src, 400, 400);
					
			  } // else

			}// else

			if (empty($_POST["description"])) {
			  $captionErr = "* caption is required";
			  $error = true;
		  } else {
			  //$description = test_input($_POST["description"]);

			  	if (!file_exists("posts.json")) {
			  		$file = fopen("posts.json", "w");
			  	} 

			  	// read json file into array of strings
					$file = "posts.json";
					$jsonstring = file_get_contents($file);
					
					//decode the string from json to PHP array
					$phparray = json_decode($jsonstring, true);

					// add form submission to data
					$_POST['username'] = $_SESSION["myName"];
				  $_POST['UID'] = file_get_contents("identifier.txt");
  				$_POST['imagetype'] = $imageFileType;
					$phparray[] = $_POST;

					// encode the php array to formatted json 
					$jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
					
					// write the json to the file
					file_put_contents($file, $jsoncode);
		  } // if 

		
	if ($error == true) {
		$page = "post";
	} else {
		$page = "feed";
	}
	
} // if 

} // main if statement 


if ($error == false && $submit == true){
		
	// read json file into array of strings
	$file = "userprofiles.json";
	$jsonstring = file_get_contents($file);
	
	//decode the string from json to PHP array
	$phparray = json_decode($jsonstring, true);

	// add form submission to data
  $_POST['UID'] = file_get_contents("identifier.txt");
  $_POST['imagetype'] = $imageFileType;
	$phparray[] = $_POST;

	// encode the php array to formatted json 
	$jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
	
	// write the json to the file
	file_put_contents($file, $jsoncode); 
	
	// create thumbnails if it doesn't exist
	if (!is_dir("thumbnails/")) {
		mkdir("thumbnails/"); 
		//echo "<br>" . "thumbnails/" . " created!<br>";
	} // if 
	
	// set source (create this folder and put this image there)
	$src = "profileimages/" . $newName;
	
	// set destination (create this folder)
	$dest = "thumbnails/" . $newName;
	
	// create a thumbnail of an image on the server
	if (!file_exists($dest)) {
		createThumbnail($src, $dest, 140, 140);
	}
} // if


if ($_SESSION["myName"] == ""){
	if ($page != "login" && $page != "form"){
		$page = "login";
	}
}

// show content
include "header.inc";

if ($_SESSION["myName"] == ""){
	$page == "login";
} else {
	$page == "login";
}

if ($page == "login") {
	include "login.inc";
} else if ($page == "form") {
	include "form.inc";
} else if ($page == "home") {
	include "home.inc";
} else if ($page == "feed") {
	include "feed.inc";
} else if (str_contains($page, "profile")){
	include "profile.inc";
} else if ($page == "post"){
	include "post.inc";
} else {
	//include "login.inc"; 
} // else 


//include "login.inc";
include "footer.inc";

// clean the data from the text boxes and text areas as it comes in from the form
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


//end 
?> 