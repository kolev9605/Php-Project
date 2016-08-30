<?php

abstract class BaseModel
{
    protected static $db;

    public function __construct()
    {
        if (self::$db == null) {
            self::$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            self::$db->set_charset("utf8");
            if (self::$db->connect_errno) {
                die('Cannot connect to database');
            }
        }
    }
	
	public function showUsername($user)
	{ ?>
		<a href="<?=APP_ROOT?>/users/userProfile?<?=$user['id']?>"><?php echo $user['username'];?></a>
	<?php 
	}
	
	public function getUserById(int $id) {
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
    }
	
	public function getUserByUsername($username) {
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.username = ?");
		$statement->bind_param("s", $username);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
    }
	
    public function getUserPosts($id) : array
    {
        $statement = self::$db->prepare("SELECT * FROM posts WHERE posts.user_id = ? ORDER BY date DESC");
        $statement->bind_param("i", $id);
        $statement->execute();

        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
