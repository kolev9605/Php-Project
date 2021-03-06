<?php if (!$this->isLoggedIn)
{
	$this->redirect("users");
}
$this->title = 'Profile'; 

$buttonIndex = 0;
?>

<div class = "userPost">
	<?php if($this->isOtherUser) : ?>
		<h2>
			<?php $this->showAvatar($this->otherUser['id']); ?>
			Posts from <?php echo $this->otherUser['username']; ?>:
		</h2>
	<?php else: ?>
		<h2>Your posts:</h2>
	<?php endif; ?>
	<article class = "userPosts" id = "userPosts">
		<?php
		$startIndex = 0;
		$index = 0;
		$startingLenght = 5;
		$this->showPosts($this->userPosts, $index, $startIndex, $startingLenght, "userPostContainer", !$this->isOtherUser);
		if(count($this->userPosts) - $startingLenght > 0)
		{
			$this->showPosts(
				$this->userPosts, 
				$index, 
				$startIndex, 
				count($this->userPosts) - $startingLenght, 
				"hiddenUserPostContainer",
				!$this->isOtherUser); 
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
	<?php if($this->isOtherUser) : ?>
		<h2>
			<?php $this->showAvatar($this->otherUser['id']); ?>
			Posts <?php echo $this->otherUser['username']; ?> has liked:
		</h2>
	<?php else: ?>
		<h2>Posts you have liked:</h2>
	<?php endif; ?>
	<article class = "userPosts" id = "userPosts">
		<?php
		$likedPostsStartIndex = 0;
		$likedPostsIndex = 0;
		$likedPostsStartingLenght = 5;
		$this->showPosts($this->likedPosts, $likedPostsIndex, $likedPostsStartIndex, $likedPostsStartingLenght, "userPostContainer", false);
		if(count($this->likedPosts) - $likedPostsStartingLenght > 0)
		{
			$this->showPosts(
				$this->likedPosts, 
				$likedPostsIndex,
				$likedPostsStartIndex,
				count($this->likedPosts) - $likedPostsStartingLenght, 
				"hiddenLikedPostContainer",
				false); 
		} ?>
	</article>
	
	<?php 
	if(count($this->likedPosts) - $likedPostsStartingLenght > 0) : ?>
		<div class = "show-hidden-posts-button-container">
			<button class = "show-hidden-posts-button" onclick = 'showAllPosts("hiddenLikedPostContainer", <?php echo $buttonIndex ?>);'
			 id = "show-hidden-posts-button_<?php echo $buttonIndex ?>">
			Show all posts
			</button>
		</div>
	<?php endif; ?>
	<hr>
</div>

<?php if($this->isOtherUser) : 
	if($this->isFollowingUser($this->otherUser['id'])) : ?>
		<button onclick = "unfollowUser(<?php echo $this->otherUser['id']; ?>)">Unfollow</button>
	<?php else : ?>
		<button onclick = "followUser(<?php echo $this->otherUser['id']; ?>)">Follow</button>
	<?php endif;
else : ?>
	<h3>Current profile image:</h3>
	<?php 
		$this->showAvatar($_SESSION['user_id']);
	?>

	<form action="pickAvatar" method="post" enctype="multipart/form-data">
		Select image to upload:
		<br>
		<input type="file" class="filestyle" data-buttontext="Find file" id="filestyle-2" tabindex="-1" name="avatarToUpload" id="avatarToUpload">
		
		<input type="submit" value="Upload Image" name="submit">
	</form>

	<hr>
	
	<?php 
	if(count($this->followedUsers))
	{ ?>
		People that you follow: 
		<br>
		<?php 
		$index = 0;
		$count = count($this->followedUsers);
		foreach($this->followedUsers as $followedUser)
		{
			$followedUserInformation = $this->model->getUserById($followedUser['followed_user_id']);
			$this->model->showUsername($followedUserInformation);
			if($index < $count - 1) : ?>
				| 
			<?php 
			$index++;
			endif;
		} ?>
		<hr>
	<?php } ?>
<?php endif;