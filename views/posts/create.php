<?php $this->title = 'Create New Post'; ?>

<h1><?=htmlspecialchars($this->title)?></h1>

<div>
	Title:
	
	<form action="create" method="post" enctype="multipart/form-data">
		<input type="text" name="post-title"/>
		<br>
		Select image to upload:
		<br>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Image" name="submit">
	</form>
</div>