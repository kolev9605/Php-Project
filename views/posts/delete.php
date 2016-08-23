<?php $this->title = 'Delete Post'; ?>

<h1>Are you sure you want to delete this post?</h1>

<form method ="post">
	<div>Title:</div><input type = "text" value = "<?=htmlspecialchars($this->post['title'])?>" disabled/>
	<br>
	<img src = "<?php echo APP_ROOT . "/content/uploads/" . $this->post['imageLocation']?>">
	<br>
	<input type = "text" value = "<?=htmlspecialchars($this->post['imageLocation'])?>" disabled/>
	<div>Date:</div><input type = "text" value = "<?=htmlspecialchars($this->post['date'])?>" disabled/>
	<div>Author ID:</div><input type = "text" value = "<?=htmlspecialchars($this->post['user_id'])?>" disabled/>
	<div><input type = "submit" value = "Delete" />
		<a href = "<?=APP_ROOT?>/home">Cancel</a></div>
</form>