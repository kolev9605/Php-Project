<?php

class PostsModel extends BaseModel
{
    public function getAll() : array {
		$statement = self::$db->query("SELECT * FROM posts ORDER BY date DESC");
		
		return $statement->fetch_all(MYSQLI_ASSOC);
    }
	
	public function getById(int $id) {
	
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
	
    }
}
