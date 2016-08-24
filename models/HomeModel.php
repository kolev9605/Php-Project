<?php

class HomeModel extends BaseModel
{
    public function getLastPosts() : array
	{
		$statement = self::$db->query(
			"SELECT posts.id, title, imageLocation, date, user_id, posts.votes " .
			"FROM posts LEFT JOIN users ON posts.user_id = users.id " .
			"ORDER BY date DESC");
		return $statement->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getPostById(int $id)
	{
		$statement = self::$db->prepare(
			"SELECT posts.id, title, date " .
			"FROM posts LEFT JOIN users ON posts.user_id = users.id " .
			"WHERE posts.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		$result = $statement->get_result()->fetch_assoc();
		return $result;
	}
	
	public function showPosts(int &$startIndex, int $count, int &$index, $posts) 
	{
		if(isset($_POST['index']))
		{
			$index = $_POST['index'];
		}
		if(isset($_POST['startIndex']))
		{
			$startIndex = $_POST['startIndex'];
		}
		$newPosts = array_slice($posts, $startIndex, $count);
		if(count($newPosts) == 0)
		{
			exit();
		}
		foreach ($newPosts as $post)
		{
			$this->showPost($post, $index, $startIndex);
		}
		if($count > count($newPosts)) : ?>
			<div class = "postContainer">
				<h2>Sorry there are no posts left to display</h2>
			</div>
		<?php endif; ?>
		
		<div class = "indexValue" style = "display:none" id = "<?php echo $index ?>">
		</div>
		
		<div class = "startIndexValue" style = "display:none"  id = "<?php echo $startIndex ?>">
		</div>
		<?php
	} 
	
	function showPost($post, &$index, &$startIndex)
	{ 
		$loggedUser = "";
		if(isset($_SESSION['user_id']))
		{
			$loggedUser = $this->getUser($_SESSION['user_id']);
		}
		?>
		<div class = "postContainer">
			<?php 
				$user = $this->getUser($post['user_id']);
			?>
			<h2 class = "post-title"><?=htmlentities($post['title'])?></h2>
			
			<?php $this->showImage($post, $index) ?>
			
			<?php $this->showVote($post, $loggedUser, $index) ?>
			
			<div class ="date">
				<i>Posted on</i>
				<?=(new DateTime($post['date']))->format('d-M-Y')?>
				<button id="show_<?php echo $index; ?>" class = "content-button" type="button" 
					onclick='showImage(<?php echo $post['id'] ?>)'>
						Show post
				</button>
				
			</div>
			<br>
			
			<div class ="post-username">
				<i>Posted by</i>
				<?php echo $user['username'];?>
			</div>
			
			<?php 
			if (isset($loggedUser['is_admin']) && $loggedUser['is_admin'] == 1) : ?>
					<a href="<?=APP_ROOT?>/posts/delete/<?=$post['id']?>">Delete post</a>
			<?php endif; ?>
			<hr>
			<?php $index++;
			$startIndex++;?>
		</div>
	<?php }
	
	function getUser($id) 
	{ 
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
	}
	
	function showImage($post, $index) 
	{ 
		$imageLocation = UPLOADS . "/" . htmlentities($post['imageLocation']);
		list($height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $imageLocation);
		if($height > 400) : 
		?>
			<div id = "image_<?php echo $index; ?>" class="post-image-container">
				<img class = "post-image" src = "<?= $imageLocation?>">
			</div>
		<?php else: ?>
			<div id = "image_<?php echo $index; ?>" class="post-image-container" style = "height: auto">
				<img class = "post-image" src = "<?= $imageLocation?>">
			</div>
		<?php endif;
	}
	
	function showVote($post, $loggedUser, $index) 
	{ ?>
		<div class = "vote">
			<?php 
			$vote = $this->vote($post, $loggedUser);
			$normalUpArrowPath = APP_ROOT . "/content/images/arrow-rotated.png";
			$normalDownArrowPath = APP_ROOT . "/content/images/arrow.png";
			$colouredUpArrowPath = APP_ROOT . "/content/images/upvote-arrow.png";
			$colouredDownArrowPath = APP_ROOT . "/content/images/downvote-arrow.png";
			if(isset($vote))
			{
				$voteIsPositive = $vote['is_positive'];
				if($voteIsPositive)
				{
					$this->showVoteImages($colouredUpArrowPath, $normalDownArrowPath, $post, $loggedUser, $index);
				}
				else 
				{
					$this->showVoteImages($normalUpArrowPath, $colouredDownArrowPath, $post, $loggedUser, $index);
				}
			} 
			else 
			{
				$this->showVoteImages($normalUpArrowPath, $normalDownArrowPath, $post, $loggedUser, $index);
			}?>
		</div>
		<?php 
	}
	
	function showVoteImages($upArrowImage, $downArrowImage, $post, $loggedUser, $index)
	{ ?>
		<img class = "arrow" id = "upArrow_<?php echo $index ?>" src = "<?php echo $upArrowImage; ?>" 
				onclick = 'vote(<?php echo isset($_SESSION["username"]); ?>, "<?php echo APP_ROOT . "/users/login"; ?>",
				<?php echo json_encode($post); ?>, <?php echo json_encode($loggedUser); ?>, true, 
				"voteNumber_<?php echo $index ?>", "<?php echo APP_ROOT ?>/content/images/", <?php echo $index ?>);'>
		<br>
		<span class = "voteNumber" id = "voteNumber_<?php echo $index ?>"><?php echo $post['votes']; ?></span>
		<br>
		<img class = "arrow" id = "downArrow_<?php echo $index ?>" src = "<?php echo $downArrowImage ?>" 
			onclick = 'vote(<?php echo isset($_SESSION["username"]); ?>, "<?php echo APP_ROOT . "/users/login"; ?>",
			<?php echo json_encode($post); ?>, <?php echo json_encode($loggedUser); ?>, false, 
				"voteNumber_<?php echo $index ?>", "<?php echo APP_ROOT ?>/content/images/", <?php echo $index ?>);'>
	<?php }
	
	function vote($post, $loggedUser)
	{
		$statement = self::$db->prepare(
            "SELECT * FROM votes WHERE votes.user_id = ? AND votes.post_id = ?"
        );

        $statement->bind_param("ii", $loggedUser['id'], $post['id']);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result;
	}
}
