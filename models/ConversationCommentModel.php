<?php

class ConversationCommentModel extends BaseModel
{	
    public function addComment($conversation, $content) {
		$user_id = $_SESSION["user_id"];
		$statement = self::$db->prepare(
            "INSERT INTO conversationcomments (content, conversation_id, user_id) VALUES (?,?,?)"
        );
		
        $statement->bind_param("sii", $content, $conversation['id'], $user_id);
        $statement->execute();
	}
}
