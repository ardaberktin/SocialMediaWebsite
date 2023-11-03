<button onclick="window.location.href='?page=feed'">Back</button><br><br>	

<div class="box">
<div id="postCard" class="card">

<h1>Post</h1>


<form id="form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	
	<label for="profilePic">Post Picture</label>
	<input id="file" type="file" id="filename" name="filename">
	<span class="error"><?php echo $postPicErr;?></span><br><br>
	
	<label for = "description">Caption:</label>
	<span class="error"><?php echo $captionErr;?></span><br>
	<textarea id = "caption" name = "description" rows = "3" cols = "30" placeholder = "caption"><?php echo $description;?></textarea><br><br>
	
	<input type = "submit" name="postPic" value = "Post">

</form>
</div>
</div>