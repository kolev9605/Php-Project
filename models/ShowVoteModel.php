<?php

class ShowVoteModel extends BaseModel
{
	function showVote($voteObject, $loggedUser, $index, $table) 
	{ ?>
		<div class = "vote">
			<?php 
			$vote = $this->vote($voteObject, $loggedUser, $table);
			$normalUpArrowPath = APP_ROOT . "/content/images/arrow-rotated.png";
			$normalDownArrowPath = APP_ROOT . "/content/images/arrow.png";
			$colouredUpArrowPath = APP_ROOT . "/content/images/upvote-arrow.png";
			$colouredDownArrowPath = APP_ROOT . "/content/images/downvote-arrow.png";
			if(isset($vote))
			{
				$voteIsPositive = $vote['is_positive'];
				if($voteIsPositive)
				{
					$this->showVoteImages($colouredUpArrowPath, $normalDownArrowPath, $voteObject, $loggedUser, $index, $table);
				}
				else 
				{
					$this->showVoteImages($normalUpArrowPath, $colouredDownArrowPath, $voteObject, $loggedUser, $index, $table);
				}
			} 
			else 
			{
				$this->showVoteImages($normalUpArrowPath, $normalDownArrowPath, $voteObject, $loggedUser, $index, $table);
			}?>
		</div>
		<?php 
	}
	
	function showVoteImages($upArrowImage, $downArrowImage, $voteObject, $loggedUser, $index, $table)
	{ 
		$url = "vote";
		$arrowClass = "Arrow";
		$voteNumberClass = "voteNumber";
		if($table == "commentvotes")
		{
			$voteNumberClass = "";
			$url = "commentVote";
			$arrowClass = "commentArrow";
		} ?>
		<img class = "up<?php echo $arrowClass; ?>" id = "upArrow_<?php echo $index ?>" src = "<?php echo $upArrowImage; ?>" 
			onclick = 'vote(
			<?php echo isset($_SESSION["username"]); ?>, 
			"<?php echo APP_ROOT . "/users/login"; ?>",
			<?php echo json_encode($voteObject); ?>, 
			<?php echo json_encode($loggedUser); ?>, 
			true, 
			"voteNumber_<?php echo $index ?>", 
			"<?php echo APP_ROOT ?>/content/images/", 
			<?php echo $index ?>, 
			"<?php echo $url ?>");'>
		<?php if($table == "votes") : ?>
			<br>
		<?php endif; ?>
		<span class = "<?php echo $voteNumberClass; ?>" id = "voteNumber_<?php echo $index ?>"><?php echo $voteObject['votes']; ?></span>
		<?php if($table == "votes") : ?>
			<br>
		<?php endif; ?>
		<img class = "<?php echo $arrowClass; ?>" id = "downArrow_<?php echo $index ?>" src = "<?php echo $downArrowImage ?>" 
			onclick = 'vote(
			<?php echo isset($_SESSION["username"]); ?>, 
			"<?php echo APP_ROOT . "/users/login"; ?>",
			<?php echo json_encode($voteObject); ?>, 
			<?php echo json_encode($loggedUser); ?>, 
			false, 
			"voteNumber_<?php echo $index ?>", 
			"<?php echo APP_ROOT ?>/content/images/", 
			<?php echo $index ?>, 
			"<?php echo $url ?>");'>
	<?php 
	}
	
	function vote($voteObject, $loggedUser, $table)
	{
		if($table == "commentvotes")
		{
			$statement = self::$db->prepare(
				"SELECT * FROM commentvotes WHERE commentvotes.user_id = ? AND commentvotes.comment_id = ?"
			);
		}
		else if ($table == "votes"){
			$statement = self::$db->prepare(
				"SELECT * FROM votes WHERE votes.user_id = ? AND votes.post_id = ?"
			);
		}

        $statement->bind_param("ii", $loggedUser['id'], $voteObject['id']);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result;
	}
}
