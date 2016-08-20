<?php $this->title = 'Welcome to our Teamwork Project Home page';?>

<h1><?=htmlspecialchars($this->title)?></h1>

<main id="posts">
	<div class = "post">
		<article class = "post">
			<?php 
			$index = 0;
			foreach ($this->posts as $post) : ?>
				<?php $_SESSION['post'] = $post; ?>
				<h2 class = "post-title"><?=htmlentities($post['title'])?></h2>
				<div id = "image_<?php echo $index; ?>" class="post-image-container">
					<img class = "post-image" src = "<?= UPLOADS . "/" . htmlentities($post['imageLocation'])?>">
				</div>
				<div class ="date">
					<i>Posted on</i>
					<?=(new DateTime($post['date']))->format('d-M-Y')?>
					<button id="show_<?php echo $index; ?>" class = "content-button" type="button" 
						onclick="showImage(<?php echo 'image_' . $index ?>, this.id, <?php echo 'hide_' . $index ?>)">
							Show post
					</button>
					<button id="hide_<?php echo $index; ?>" class = "content-button" type="button" style = "display:none" 
						onclick="hideImage(<?php echo 'image_' . $index ?>, <?php echo 'show_' . $index ?>, this.id)"> 
							Hide post
					</button>
				</div>
				<hr>
				<?php $index++; ?>
			<?php endforeach?>
		</article>
	</div>
</main>
