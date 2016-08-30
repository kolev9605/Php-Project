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

				<script type="text/javascript">
					let index = <?php echo $index?>;
					let startIndex = <?php echo $startIndex?>;
					$( window ).scroll(function() {
						if($(window).scrollBottom() < PIXELS_FROM_BOTTOM_BEFORE_MORE_POSTS && $.active == 0)
						{
							showPosts(true);
						}
					});
					
					function showPosts(onScrollDown = false) {
						if(onScrollDown)
						{
							$.ajax({
									type: "POST",
									url: '',
									data: {
										index: index,
										startIndex: startIndex
									},
									success: function( data ) {
										if (!(typeof $(data).find(".indexValue").attr("id") === "undefined")) {
											result = $(data).find(".postContainer");
											$("#articlePosts").append(result);
											index = $(data).find(".indexValue").attr("id");
											startIndex = $(data).find(".startIndexValue").attr("id");
										}
									}
								});
						}
					}
				</script>
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