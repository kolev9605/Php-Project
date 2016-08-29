<?php

class ConversationsController extends BaseController
{
    function onInit() {
		$this->authorize();
    }
	
	public function index() {
		$this->conversations = $this->model->getAll();
    }
	
	public function create() {
		if($this->isPost) {
			$title = $_POST['conversation-title'];
			if(strlen($title) < 1) {
				$this->setValidationError("conversation-title", "Title cannot be empty!");
			}
			$participants = array_filter(explode(",", $_POST['conversation-participants']), 'strlen' );
			array_unshift($participants, $_SESSION['username']);
			if(count($participants) < 1) {
				$this->setValidationError("conversation-participants", "No participants!");
			}
			foreach($participants as &$participant)
			{
				$participant = trim($participant);
			}
			$participants = array_unique($participants);
			$content = $_POST['conversation-content'];
			if(strlen($content) < 1) {
				$this->setValidationError("conversation-content", "Content cannot be empty!");
			}
			
			$commentID = $this->model->create($title);
			$this->model->addParticipants($commentID, $participants);
			$this->model->addComment($commentID, $_SESSION['user_id'], $content);
			$this->redirect("conversations");
		}
    }
	
	public function getUserById(int $id) {
		return $this->model->getUserById($id);
	}
	
	public function getParticipantsById(int $id) {
		return $this->model->getParticipantsById($id);
    }
	
	public function users() {
		$partialUsername = $_POST['value'];
		$users = $this->model->getUsersWithPartialUsername($partialUsername);
		$users = array_splice($users, 0, 3);
		foreach($users as $user) : ?>
			<div class = "dropdownUsername" onclick = 'addUsername("<?php echo $user['username']; ?>")'>
				<i><?php echo $user['username']; ?></i>
			</div>
    <?php endforeach;
	}
	
	public function conversation() {
		$conversationID = $_SERVER['QUERY_STRING'];
		if($this->model->isParticipant($conversationID))
		{
			$this->comments = $this->model->getCommentsFromConversationID($conversationID);
		}
		else
		{
            $this->redirect("conversations");
		}
    }
	
	public function showComment($comment) {
		$this->model->showComment($comment);
    }
}
