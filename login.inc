<?php   
	session_destroy(); //destroy the session
?>

<!--<a href = "index.php?deleteAll=true">Reset Gallery</a><br>-->

<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	
	
	<div class="box">
		<div class="card">
			<div id="Jastagram">
				<label id="jastagram">JASTAGRAM</label><br>
			</div>
			<div id="typeUsername">
				<span class="error"><?php echo $usernameErr;?></span><br>
				
				<textarea id="username" name="username" rows="1" cols="20" placeholder="Username"></textarea><br>
			</div>
			<div id="loginBtn">
			<input id="clickLogin" type = "submit" name="LogIn" value = "Log In"><br>
			</form>
			</div>
			
			 <button id="signUp"><a href="index.php?page=form">Sign Up</a></button>
				
 		</div>
	
	</div>