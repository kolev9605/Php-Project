<?php

class HomeModel extends BaseModel
{
    public function getLastPosts() : array
	{
		$statement = self::$db->query(
			"SELECT posts.id, title, imageLocation, date " .
			"FROM posts LEFT JOIN users ON posts.user_id = users.id " .
			"ORDER BY date DESC");
		return $statement->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getPostById(int $id)
	{
		$statement = self::$db->prepare(
			"SELECT posts.id, title, date " .
			"FROM posts LEFT JOIN users ON posts.user_id = users.id " .
			"WHERE posts.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		$result = $statement->get_result()->fetch_assoc();
		return $result;
	}
}
