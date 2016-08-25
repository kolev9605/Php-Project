<?php

class PostsModel extends ShowVoteModel
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
	
	public function showComment($comment, $loggedUser, $index)
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
		<?php 
		$this->showVote($comment, $loggedUser, $index, "commentvotes") ?>
		<hr>
	<?php }
}
