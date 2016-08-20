<?php $this->title = 'Posts'; ?>

<?php $post = $_SESSION['post'];?>

<article class = "viewedPost">
	<h2 class = "post-title"><?=htmlentities($post['title'])?></h2>
	<img class = "post-image" src = "<?= UPLOADS . "/" . htmlentities($post['imageLocation'])?>">
	<div class ="date">
		<i>Posted on</i>
		<?=(new DateTime($post['date']))->format('d-M-Y')?>
	</div>
<article>