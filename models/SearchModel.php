<?php

class SearchModel extends HomeModel
{
    public function getSearchedPosts($searchTerm) : array
	{
		$statement = self::$db->prepare(
			"SELECT * " .
			"FROM posts WHERE title LIKE ? " .
			"ORDER BY date DESC");
			
		$searchTermExpanded = "%" . $searchTerm . "%";
        $statement->bind_param("s", $searchTermExpanded);
        $statement->execute();
		return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
	}
}
