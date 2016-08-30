<?php

class VoteModel extends BaseModel
{
    public function getVote($post, $loggedUser) {
		$statement = self::$db->prepare(
            "SELECT * FROM votes WHERE votes.user_id = ? AND votes.post_id = ?"
        );

        $statement->bind_param("ii", $loggedUser['id'], $post['id']);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result;
    }
	
	public function createVote($post, $loggedUser, $isUpVote) {
		$isUpVoteAsInt = 0;
		if($isUpVote)
		{
			$isUpVoteAsInt = 1;
		}
		$statement = self::$db->prepare(
            "INSERT INTO votes (votes.user_id, votes.post_id, votes.is_positive) VALUES (?,?,?)"
        );
		
        $statement->bind_param("iii", $loggedUser['id'], $post['id'], $isUpVoteAsInt);
        $statement->execute();
    }
	
    public function vote($post, $isUpVote, $newVotes) {
		$statement = self::$db->prepare(
            "UPDATE posts SET posts.votes = ? WHERE posts.id = ?"
        );

        $statement->bind_param("ii", $newVotes, $post['id']);
        $statement->execute();
    }
	
    public function moveToHot($post) {
		$statement = self::$db->prepare(
            "UPDATE posts SET posts.is_hot = 1 WHERE posts.id = ?"
        );

        $statement->bind_param("i", $post['id']);
        $statement->execute();
    }
	
    public function removeVote($post, $loggedUser) {
		$statement = self::$db->prepare(
            "DELETE FROM votes WHERE votes.post_id = ? AND votes.user_id = ?"
        );

        $statement->bind_param("ii", $post['id'], $loggedUser['id']);
        $statement->execute();
    }
	
    public function changeVote($id, $voteValue) {
		$statement = self::$db->prepare(
            "UPDATE votes SET votes.is_positive = ? WHERE votes.id = ?"
        );

        $statement->bind_param("ii", $voteValue, $id);
        $statement->execute();
    }
	
	public function getPostVotes($id){
		$statement = self::$db->prepare(
            "SELECT posts.votes FROM posts WHERE posts.id = ?"
        );

        $statement->bind_param("i", $id);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_assoc();
		return $result['votes'];
	}
}
