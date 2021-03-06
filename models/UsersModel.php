<?php

class UsersModel extends BaseModel
{
    public function getAll() : array
    {
        $statement = self::$db->query("SELECT * FROM users ORDER BY username");

        return $statement->fetch_all(MYSQLI_ASSOC);
    }
	
    public function userExists($id) 
    {
		$statement = self::$db->prepare("SELECT * FROM users WHERE users.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
    }
	
    public function getLikedPosts($id) : array
    {
        $statement = self::$db->prepare("SELECT * FROM votes WHERE votes.user_id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();

		$result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
		$posts = [];
		foreach($result as $vote)
		{
			if($vote['is_positive'])
			{
				$post = $this->getPostFromVote($vote['post_id']);
				if($post)
				{
					$posts[] = $post;
				}
			}
		}
        return $posts;
    }
	
	function getPostFromVote($id) 
	{ 
		$statement = self::$db->prepare("SELECT * FROM posts WHERE posts.id = ?");
		$statement->bind_param("i", $id);
		$statement->execute();
		return $statement->get_result()->fetch_assoc();
	}

    public function login(string $username, string $password)
    {
        $statement = self::$db->prepare(
            "SELECT id, password_hash FROM users WHERE username = ?"
        );

        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if(password_verify($password, $result['password_hash'])) {
            return $result['id'];
        }

        return false;
    }

    public function register(string $username, string $password)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = self::$db->prepare(
            "INSERT INTO users (username, password_hash) VALUES (?,?)"
        );

        $statement->bind_param("ss", $username, $password_hash);
        $statement->execute();
        if($statement->affected_rows != 1) {
            return false;
        }

        $user_id = self::$db->query("SELECT LAST_INSERT_ID()")->fetch_row()[0];

        return $user_id;
    }

    public function followUser($followedUserId)
    {
        $statement = self::$db->prepare(
            "INSERT INTO followers (user_id, followed_user_id) VALUES (?,?)"
        );

        $statement->bind_param("ss", $_SESSION['user_id'], $followedUserId);
        $statement->execute();
    }

    public function unfollowUser($followedUserId)
    {
        $statement = self::$db->prepare(
            "DELETE FROM followers WHERE followers.user_id = ? AND followers.followed_user_id = ?"
        );

        $statement->bind_param("ss", $_SESSION['user_id'], $followedUserId);
        $statement->execute();
    }

    public function isFollowingUser($followedUserId)
    {
        $statement = self::$db->prepare(
            "SELECT * FROM followers WHERE followers.user_id = ? AND followers.followed_user_id = ?"
        );

        $statement->bind_param("ss", $_SESSION['user_id'], $followedUserId);
        $statement->execute();
		
		return $statement->get_result()->fetch_assoc();
    }

    public function getFollowedUsers($userID) : array
    {
        $statement = self::$db->prepare(
            "SELECT followers.followed_user_id FROM followers WHERE followers.user_id = ?"
        );

        $statement->bind_param("s", $userID);
        $statement->execute();
		
		$result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
		
		return $result;
    }
	
	public function showPosts($posts, &$index, &$startIndex, $count, $userPostContainerClass, $canDeletePost) 
	{
		$newPosts = array_slice($posts, $startIndex, $count);
		foreach ($newPosts as $post)
		{
			$this->showPost($post, $startIndex, $index, $userPostContainerClass, $canDeletePost);
		}
	} 
	
	function showPost($post, &$startIndex, &$index, $userPostContainerClass, $canDeletePost)
	{ ?>
		<div class = "<?php echo $userPostContainerClass; ?>">
			<h2 class = "post-title"><?=htmlentities($post['title'])?></h2>
			
			<?php $this->showImage($post, $index) ?>
			
			<div class ="date">
				<i>Posted on</i>
				<?=(new DateTime($post['date']))->format('d-M-Y')?>
				<br>
				<button id="show_<?php echo $index; ?>" class = "user-content-button" type="button" 
					onclick='showImage(<?php echo $post['id'] ?>)'>
						Show post
				</button>
				
			</div>
			<br>
			
			<?php if($canDeletePost) : ?>
				<a href="<?=APP_ROOT?>/posts/delete/<?=$post['id']?>">Delete post</a>
			<?php endif;
			$index++;
			$startIndex++;?>
		</div>
	<?php }
	
	function showImage($post, $index) 
	{ 
		$imageLocation = UPLOADS . "/" . htmlentities($post['imageLocation']);
		list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $imageLocation);
		if($height / $width >= 2) : 
		?>
			<div id = "image_<?php echo $index; ?>" class="user-post-image-container">
				<img class = "user-post-image" src = "<?= $imageLocation?>">
			</div>
		<?php else: ?>
			<div id = "image_<?php echo $index; ?>" class="user-post-image-container" style = "height: auto">
				<img class = "user-post-image" src = "<?= $imageLocation?>">
			</div>
		<?php endif;
	}
	
	function showAvatar($id)
	{
		$target_dir = AVATARS;
		$avatarImageLocation = $target_dir . "/default.png";
		$result = glob ($target_dir . "/" . $id . ".*");
		if($result) {
			$avatarImageLocation = $result[0];
		}
	?>
	<img class = "avatar" src = "<?php echo APP_ROOT . "/" . $avatarImageLocation; ?>">
	<?php }
}
