<?php 
$this->title = 'Welcome to our Teamwork Project Home page';?>

<main id="posts">
	<div class = "post">
		<article class = "post" id = "articlePosts">
			<?php 
			$index = 0;
			$startIndex = 0;
			$length = 5;
			$this->showPosts($startIndex, $length, $index);
			?>
			<div class = "indexDivValue"><?php echo $index ?></div> 
			<div class = "startIndexDivValue"><?php echo $startIndex ?></div>
		</article>
	</div>
</main>