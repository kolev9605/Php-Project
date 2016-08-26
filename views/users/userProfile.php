<?php if (!$this->isLoggedIn)
{
	$this->redirect("users");
}
$this->title = 'Profile'; 

$buttonIndex = 0;
?>

<div class = "userPost">
	<h2>Your posts:</h2>
	<article class = "userPosts" id = "userPosts">
		<?php
		$startIndex = 0;
		$index = 0;
		$startingLenght = 5;
		$this->showPosts($this->userPosts, $index, $startIndex, $startingLenght);
		if(count($this->userPosts) - $startingLenght > 0)
		{
			$this->showPosts($this->userPosts, $index, $startIndex, count($this->userPosts) - $startingLenght, "hiddenUserPostContainer"); 
		} ?>
	</article>
	
	<?php 
	if(count($this->userPosts) - $startingLenght > 0) : ?>
		<div class = "show-hidden-posts-button-container">
			<button class = "show-hidden-posts-button" onclick = 'showAllPosts("hiddenUserPostContainer", <?php echo $buttonIndex ?>);'
			 id = "show-hidden-posts-button_<?php echo $buttonIndex ?>">
			Show all posts
			</button>
		</div>
	<?php endif; ?>
	<hr>
</div>

<?php $buttonIndex++ ?>

<div class = "userPosts">
	<h2>Posts you have liked:</h2>
	<article class = "userPosts" id = "userPosts">
		<?php
		$likedPostsStartIndex = 0;
		$likedPostsIndex = 0;
		$likedPostsStartingLenght = 5;
		$this->showPosts($this->likedPosts, $likedPostsIndex, $likedPostsStartIndex, $likedPostsStartingLenght);
		if(count($this->userPosts) - $likedPostsStartingLenght > 0)
		{
			$this->showPosts($this->likedPosts, $likedPostsIndex, $likedPostsStartIndex, count($this->userPosts) - $likedPostsStartingLenght, "hiddenLikedPostContainer"); 
		} ?>
	</article>
	
	<?php 
	if(count($this->userPosts) - $likedPostsStartingLenght > 0) : ?>
		<div class = "show-hidden-posts-button-container">
			<button class = "show-hidden-posts-button" onclick = 'showAllPosts("hiddenLikedPostContainer", <?php echo $buttonIndex ?>);'
			 id = "show-hidden-posts-button_<?php echo $buttonIndex ?>">
			Show all posts
			</button>
		</div>
	<?php endif; ?>
	<hr>
</div>

<div class="user-profile-block">
	<a href = "<?=APP_ROOT?>/posts/create">Create New Post</a>
</div>