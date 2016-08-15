<?php if (!$this->isLoggedIn)
{
	$this->redirect("users");
}
$this->title = 'Profile'; ?>

<div class="user-profile-block">
	<a href = "<?=APP_ROOT?>/posts/create">Create New Post</a>
</div>