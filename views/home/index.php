<?php $this->title = 'Welcome to our Teamwork Project Home page';?>

<h1><?=htmlspecialchars($this->title)?></h1>

<main id="posts">
	<article>
		<?php foreach ($this->posts as $post) : ?>
			<h2 class = "title"><?=htmlentities($post['title'])?></h2>
			<div class ="date"><i>Posted on</i>
				<?=(new DateTime($post['date']))->format('d-M-Y')?>
			</div>
		<?php endforeach?>
	</article>
</main>
