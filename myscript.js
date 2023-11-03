
// get grade to display when current student is selected 
window.onload = function (){
	
	if (document.getElementById("currentStudent").checked == true) {
		document.getElementById("grades").style.display = "block";
	}
	
	document.getElementById("currentStudent").onchange = function(){
		
		if (document.getElementById("currentStudent").checked == true) {
			document.getElementById("grades").style.display = "block";
	    } 
	};
	
	document.getElementById("alumni").onchange = function(){
		if (document.getElementById("alumni").checked == true) {
			document.getElementById("grades").style.display = "none";
			document.getElementById("grades").value = "Select grade";
	    }
	};
	
	document.getElementById("staff").onchange = function(){
		if (document.getElementById("staff").checked == true) {
			document.getElementById("grades").style.display = "none";
			document.getElementById("grades").value = "Select grade";
	    }
	};
	
}

/*--------------------------- display user info with the post in feed */

function gotoProfile(username){
	window.location.href = "http://142.31.53.220/~JAS/sadikshya_ramfinal/index.php?page=profile?name=" + username;
}


function gotoProfile2(username){
	
	const splittedArray = username.split(".");
	let requestedUsername = splittedArray[0];
	
	if (username != "") {
		
		fetch("http://142.31.53.220/~JAS/sadikshya_ramfinal/getData.php?uid=" + requestedUsername)
    	.then(response => response.json())
    	.then(data => changeUrl(data) )
    	.catch(err => console.log("error occurred " + err));
	}
	
}

function changeUrl(data){
	let name = data.name;
	window.location.href = "http://142.31.53.220/~JAS/sadikshya_ramfinal/index.php?page=profile?name=" + name;
}

/*function displayPostInfo(data, imageFile){
	
	let postUserID = data;
	const splittedArray = imageFile.split(".");
	let requestedUid = splittedArray[0];

	if (imageFile != "") {
		
		fetch("http://142.31.53.220/~JAS/sadikshya_ramfinal/getData.php?uid=" + requestedUid)
    	.then(response => response.json())
    	.then(data => updatePostCont(data, postUserID))
    	.catch(err => console.log("error occurred " + err));
	}
}*/

function displayInfo(data, imageFile, displayNameId){

	let userID = data;
	const splittedArray = imageFile.split(".");
	let requestedUid = splittedArray[0];

	if (imageFile != "") {
		
		fetch("http://142.31.53.220/~JAS/sadikshya_ramfinal/getData.php?uid=" + requestedUid)
    	.then(response => response.json())
    	.then(data => updatePostCont(data, displayNameId))
    	.catch(err => console.log("error occurred " + err));
	}
}


function updatePostCont(data, displayNameId){
	document.getElementById(displayNameId).innerHTML = data.name;
}

/*---------------------*/

// lightbox code
//------------------ 

// change the visibility of divId
function changeVisibilty (divId){
  let elem = document.getElementById(divId);
  
  // if element exists, it is considered true
  if (elem){
	elem.className = (elem.className == 'hidden') ? 'unhidden' : 'hidden';
  } // if
  
} // changeVisibilty

function updateContents(data) {
	//console.log(data);
	document.getElementById("displayName").innerHTML = data.name;
	document.getElementById("displayConnection").innerHTML = data.connection;
	document.getElementById("displayDescription").innerHTML = data.description;

	if (data.connection == "currentStudent"){
		document.getElementById("displayGrade").innerHTML = data.grade;
	} else {
		document.getElementById("displayGrade").innerHTML = "";
	}
}

// display lightbox with big image in it
function displayLightBox(alt, imageFile, folder){
	let bigImage = document.getElementById("bigImage");
	let image = new Image();
	const splittedArray = imageFile.split(".");
	let requestedUid = splittedArray[0];

	// update the big image to access
	image.src = folder + imageFile;
	
	// force big image to preload so we can access width
	// to center image on page
	image.onload = function () {
		let width = image.width;
		document.getElementById("boundaryBigImage").style.width = width + "px";
	};
	
	bigImage.src = image.src;
	bigImage.alt = alt;
	
	changeVisibilty("lightbox");
	changeVisibilty("positionBigImage");

	document.getElementById("download").download = imageFile;
	document.getElementById("download").href = image.src;

/*	if (imageFile != "") {
		fetch("http://142.31.53.220/~JAS/sadikshya_ramfinal/getData.php?uid=" + requestedUid)
    	.then(response => response.json())
    	.then(data => updateContents(data))
    	.catch(err => console.log("error occurred " + err));
    }*/
	
} // displayLightBox

// load images js
//--------------------------

// load "all", "private", or "public" images only
function loadImages(connection){
  fetch("./readjson.php?connection=" + connection).
    then(function(resp){ 
      return resp.json();
    })
    .then(function(data){
       
      let i;  // counter     
      let main = document.getElementById("bigBox");
      //console.log(data);
      // remove all existing children of main
      while (main.firstChild) {
        main.removeChild(main.firstChild);
      }
     
      // for every image, create a new image object and add to main
      for (i in data){
        let img = new Image();
        //console.log(img.src);
        img.src = "thumbnails/" + data[i].UID + "." + data[i].imagetype;
        img.alt = data[i].description;
        let userName = data[Object.keys(data)[i]]["name"];
        
        let labelTag = document.createElement("label");
	      let node = document.createTextNode(userName);
	      labelTag.setAttribute('class', 'displayInfo');


	      labelTag.appendChild(node);
	      
        main.appendChild(img);
        main.appendChild(labelTag);
        main.appendChild(document.createElement("br"));


      }
    });
} // loadImages