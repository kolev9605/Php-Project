<?php

class ConversationsModel extends BaseModel
{
    public function getAll() : array {
		$statement = self::$db->query("SELECT * FROM conversations ORDER BY conversations.date DESC");
		
		return $statement->fetch_all(MYSQLI_ASSOC);
    }
	
	public function getById(int $id) {
		$statement = self::$db->prepare(
			"SELECT * FROM conversations WHERE id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		$result = $statement->get_result()->fetch_assoc();
		return $result;
    }
	
	public function create(string $title){
		$statement = self::$db->prepare(
			"INSERT INTO conversations(title) VALUES(?)");
		$statement->bind_param("s", $title);
		$statement->execute();
		return self::$db->insert_id;
    }
	
	public function addParticipants($id, $participants){
		foreach($participants as $participant)
		{
			$user = $this->getUserByUsername($participant);
			$statement = self::$db->prepare(
				"INSERT INTO conversationparticipants(conversation_id, user_id) VALUES(?, ?)");
			$statement->bind_param("ii", $id, $user['id']);
			$statement->execute();
		}
    }
	
	public function isParticipant($id){
		$statement = self::$db->prepare(
			"SELECT * FROM conversationparticipants " . 
			"WHERE conversationparticipants.conversation_id = ? AND conversationparticipants.user_id = ?");
		$statement->bind_param("ii", $id, $_SESSION['user_id']);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
    }
	
	public function getParticipantsById($id) {
		$statement = self::$db->prepare("SELECT * FROM conversationparticipants WHERE conversationparticipants.conversation_id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		
		return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
	
	public function getUsersWithPartialUsername($partialUsername) {
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.username LIKE ?");
		$searchTermExpanded = "%" . $partialUsername . "%";
		$statement->bind_param("s", $searchTermExpanded);
		$statement->execute();
		
		return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
	
	public function addComment($id, $userID, $content){
		$statement = self::$db->prepare(
			"INSERT INTO conversationcomments(conversation_id, user_id, content) VALUES(?, ?, ?)");
		$statement->bind_param("iis", $id, $userID, $content);
		$statement->execute();
    }
	
	public function getCommentsFromConversationID($id){
		$statement = self::$db->prepare(
			"SELECT * FROM conversationcomments WHERE conversationcomments.conversation_id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		
		return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
	
	public function showComment($comment)
	{
		$this->showProfilePicture($comment['user_id']);
		$user = $this->getUserById($comment['user_id']);
		?>
		<span>
			<b><?php $this->showUsername($user); ?></b> Posted:</span>
		<div class = "commentText">
			<?php echo $comment['content'] ?>
		</div>
		<br>
		<div class ="date">
			<i>Posted on</i>
			<?=(new DateTime($comment['date']))->format('d-M-Y')?>
		</div>
		<hr>
	<?php }
	
	function showProfilePicture($id)
	{
		$target_dir = AVATARS;
		$avatarImageLocation = $target_dir . "/default.png";
		$result = glob ($target_dir . "/" . $id . ".*");
		if($result) {
			$avatarImageLocation = $result[0];
		}
		?>
		<img class = "avatar" src = "<?php echo APP_ROOT . "/" . $avatarImageLocation; ?>">
		<?php
	}
}
