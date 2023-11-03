
<button onclick="window.location.href='?page=feed'">Back</button><br><br>	

<div id="box">
<div id="signCard" class="card">

<h1>Sign Up</h1>

<form id="signForm" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
  
    <label for="name">Name:</label><br>
    <input type="text" id ="name" name="name" value="<?php echo $name;?>">
    <span class="error"><?php echo $nameErr;?></span><br><br>
		  
	<label for="profilePic">Profile Pic:</label>
	<input type="file" id="filename" name="filename">
	<span class="error"><?php echo $filenameErr;?></span><br>
		  
	<input type="checkbox" id="consent" name = "consent"  <?php if(isset($_POST['consent'])) echo "checked='checked'"; ?> >
	<label for = "consent"> I give RamBook non-exclusive, 
	 transferable, sub-licensable, royalty-free, worldwide license to use this photo.</label>
	<span class="error"><?php echo $consentErr;?></span><br><br>
	
	<label> Connection to Mount Doug: </label>
	<span class="error"><?php echo $connectionErr;?></span><br>
		  
	<input type = "radio" id = "currentStudent" name = "connection" <?php if (isset($connection) && $connection=="currentStudent") echo "checked";?> value = "currentStudent">

	<label for = "currentStudent"> Current Student </label>
		 
	<span class = "error"> <?php echo $gradeErr;?></span><br> 
	<select name = "grade" id = "grades">
		<option disabled selected value = "Select grade">Select Grade</option>
		<option <?php if (isset($grade) && $grade=="Grade 9") echo "selected";?> value="Grade 9">Grade 9</option>
		<option <?php if (isset($grade) && $grade=="Grade 10") echo "selected";?> value="Grade 10">Grade 10</option>
		<option <?php if (isset($grade) && $grade=="Grade 11") echo "selected";?> value="Grade 11">Grade 11</option>
		<option <?php if (isset($grade) && $grade=="Grade 12") echo "selected";?> value="Grade 12">Grade 12</option>
	</select>

		  
	<input type = "radio" id = "alumni" name = "connection" <?php if (isset($connection) && $connection=="alumni") echo "checked";?> value = "alumni">
	<label for = "alumni"> Alumni </label><br>
		 
	<input type = "radio" id = "staff" name = "connection" <?php if (isset($connection) && $connection=="staff") echo "checked";?> value = "staff">
	<label for = "staff"> Staff </label><br><br>
		  
	<label for = "description">Say Something About Yourself:</label>
	<span class="error"><?php echo $descriptionErr;?></span><br>
	<textarea id = "description" name = "description" rows = "4" cols = "50" placeholder = "say something here"><?php echo $description;?></textarea><br><br>
	
	<input type = "submit" name="addProfile" value = "Sign Up">
</form>
</div>
</div>