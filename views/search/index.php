<?php 
$this->title = 'Search results';?>

<main id="posts">
	<div class = "post">
		<article class = "post" id = "articlePosts">
			<?php 
			if(count($this->posts) > 0)
			{
				$index = 0;
				$startIndex = 0;
				$length = 5;
				$this->showPosts($startIndex, $length, $index);
				?>
				<div class = "indexDivValue"><?php echo $index ?></div> 
				<div class = "startIndexDivValue"><?php echo $startIndex ?></div>
			<?php }
			else 
			{ 
				if(isset($this->foundUser))
				{ ?>
					<h3>There are no posts matching the search posted by: <i><?php $this->model->showUsername($this->foundUser) ?></i></h3>
				<?php 
				}
				else
				{ ?>
					<h3>There are no posts matching the search. Please make sure what you have typed everything correctly into the search bar</h3>
				<?php 
				}
			} ?>
		</article>
	</div>
</main>