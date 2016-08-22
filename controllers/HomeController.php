<?php

class HomeController extends BaseController
{
    function index() {
		$lastPosts = $this->model->getLastPosts();
		$this->posts = $lastPosts;
		$this->sidebarPosts = $lastPosts;
    }
	
	function view($id) {
		$this->post = $this->model->getPostById($id);
    }
	
	function showPosts(int &$startIndex, int $count, int &$index) 
	{
		if(isset($_POST['index']))
		{
			$index = $_POST['index'];
		}
		if(isset($_POST['startIndex']))
		{
			$startIndex = $_POST['startIndex'];
		}
		$newPosts = array_slice($this->posts, $startIndex, $count);
		if(count($newPosts) == 0)
		{
			exit();
		}
		foreach ($newPosts as $post) :
			$_SESSION['post'] = $post;?>
			<div class = "postContainer">
				<h2 class = "post-title"><?=htmlentities($post['title'])?></h2>
				
				<?php $imageLocation = UPLOADS . "/" . htmlentities($post['imageLocation']);
				list($height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $imageLocation);
				if($height > 400) : 
				?>
					<div id = "image_<?php echo $index; ?>" class="post-image-container">
						<img class = "post-image" src = "<?= $imageLocation?>">
					</div>
				<?php else: ?>
					<div id = "image_<?php echo $index; ?>" class="post-image-container" style = "height: auto">
						<img class = "post-image" src = "<?= $imageLocation?>">
					</div>
				<?php endif; ?>
				
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
				<?php 
				$index++;
				$startIndex++;?>
			</div>
		<?php endforeach;
		if($count > count($newPosts)) : ?>
			<div class = "postContainer">
				<h2>Sorry there are no posts left to display</h2>
			</div>
		<?php endif; ?>
		
		<div class = "indexValue" style = "display:none" id = "<?php echo $index ?>">
		</div>
		
		<div class = "startIndexValue" style = "display:none"  id = "<?php echo $startIndex ?>">
		</div>
		<?php
	} 
}
