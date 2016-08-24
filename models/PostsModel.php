<?php

class PostsModel extends BaseModel
{
    public function getAll() : array {
		$statement = self::$db->query("SELECT * FROM posts ORDER BY posts.date DESC");
		
		return $statement->fetch_all(MYSQLI_ASSOC);
    }
	
	public function getUserById(int $id) {
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
    }
	
	public function getById(int $id) {
		$statement = self::$db->prepare(
			"SELECT * FROM posts WHERE id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		$result = $statement->get_result()->fetch_assoc();
		return $result;
    }
	
	public function create(string $title, string $imageSource, int $user_id) : bool {
		$statement = self::$db->prepare(
			"INSERT INTO posts(title, imageLocation, user_id) VALUES(?, ?, ?)");
		$statement->bind_param("ssi", $title, $imageSource, $user_id);
		$statement->execute();
		return $statement->affected_rows == 1;
    }
	
	public function edit(string $id, string $title, string $content, string $date, int $user_id) : bool {
	
    }
	
	public function delete(int $id) {
		$statement = self::$db->prepare(
			"DELETE FROM posts WHERE id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		$statementVote = self::$db->prepare(
			"DELETE FROM votes WHERE votes.comment_id = ?");
		$statementVote->bind_param("i", $id);
		$statementVote->execute();
		return $statement->affected_rows == 1;
    }
	
    public function getAllComments() : array {
		$statement = self::$db->query("SELECT * FROM comments ORDER BY comments.date DESC");
		
		return $statement->fetch_all(MYSQLI_ASSOC);
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
	<?php 
	}
	
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
	
	public function showComment($comment)
	{ ?>
		<h4><?php echo $_SESSION['username'] ?> Posted:</h4>
		<div class = "commentText">
			<?php echo $comment['content'] ?>
		</div>
		<br>
		<div class ="date">
			<i>Posted on</i>
			<?=(new DateTime($comment['date']))->format('d-M-Y')?>			
		</div>
	<?php }
}
