<?php

class PostsModel extends BaseModel
{
    public function getAll() : array {
		$statement = self::$db->query("SELECT * FROM posts ORDER BY date DESC");
		
		return $statement->fetch_all(MYSQLI_ASSOC);
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
}
