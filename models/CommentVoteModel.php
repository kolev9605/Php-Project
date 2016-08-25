<?php

class CommentVoteModel extends BaseModel
{
    public function getVote($comment, $loggedUser) {
		$statement = self::$db->prepare(
            "SELECT * FROM commentvotes WHERE commentvotes.user_id = ? AND commentvotes.comment_id = ?"
        );

        $statement->bind_param("ii", $loggedUser['id'], $comment['id']);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result;
    }
	
	public function createVote($comment, $loggedUser, $isUpVote) {
		$isUpVoteAsInt = 0;
		if($isUpVote)
		{
			$isUpVoteAsInt = 1;
		}
		$statement = self::$db->prepare(
            "INSERT INTO commentvotes (commentvotes.user_id, commentvotes.comment_id, commentvotes.is_positive) VALUES (?,?,?)"
        );
		
        $statement->bind_param("iii", $loggedUser['id'], $comment['id'], $isUpVoteAsInt);
        $statement->execute();
    }
	
    public function vote($comment, $isUpVote, $newVotes) {
		$statement = self::$db->prepare(
            "UPDATE comments SET comments.votes = ? WHERE comments.id = ?"
        );

        $statement->bind_param("ii", $newVotes, $comment['id']);
        $statement->execute();
    }
	
    public function changeVote($id, $voteValue) {
		$statement = self::$db->prepare(
            "UPDATE commentvotes SET commentvotes.is_positive = ? WHERE commentvotes.id = ?"
        );

        $statement->bind_param("ii", $voteValue, $id);
        $statement->execute();
    }
	
	public function getCommentVotes($id){
		$statement = self::$db->prepare(
            "SELECT comments.votes FROM comments WHERE comments.id = ?"
        );

        $statement->bind_param("i", $id);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result['votes'];
	}
}
