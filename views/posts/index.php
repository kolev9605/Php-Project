<?php $this->title = 'Posts'; ?>

<?php $postID = $_SERVER['QUERY_STRING']; 

$post = $this->getPostById($postID);?>

<article class = "viewedPost">
	<h2 class = "post-title"><?=htmlentities($post['title'])?></h2> 
	<?php 
	$loggedUser = "";
	if(isset($_SESSION['user_id']))
	{
		$loggedUser = $this->getUserById($_SESSION['user_id']);
	}
	
	$this->showVote($post, $loggedUser, 0, "votes") ?>
	<img class = "post-image" src = "<?= UPLOADS . "/" . htmlentities($post['imageLocation'])?>">
	<div class ="date">
		<i>Posted on</i>
		<?=(new DateTime($post['date']))->format('d-M-Y')?>
	</div>
	<?php if(isset($_SESSION["username"])) : ?>
		<textarea class = "commentField" type="text" rows = "5" id = "commentContent" name = "commentContent" placeholder = "Add your comment here"></textarea>
		<br>
		<button class="commentSubmit" 
		onclick='addComment(<?php echo json_encode($post); ?> )'>Comment</button>
	<?php endif;
	$comments = $this->comments($post);
	$index = 1;
	if(isset($comments))
	{
		foreach ($comments as $comment)
		{
			$this->showComment($post, $comment, $loggedUser, $index);
			$index++;
		}
	}
	else
	{ ?>
		<h3>There are no comments on this post. Be the first to comment.</h3>
	<?php }	?>
<article>