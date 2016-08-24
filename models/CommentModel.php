<?php

class CommentModel extends BaseModel
{	
    public function addComment($post, $content) {
		$user_id = $_SESSION["user_id"];
		$statement = self::$db->prepare(
            "INSERT INTO comments (comments.content, comments.post_id, comments.user_id) VALUES (?,?,?)"
        );
		
        $statement->bind_param("sii", $content, $post['id'], $user_id);
        $statement->execute();
	}
}
