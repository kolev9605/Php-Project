<?php 
$this->title = 'Search results';?>

<main id="posts">
	<div class = "post">
		<article class = "post" id = "articlePosts">
			<?php 
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
		</article>
	</div>
</main>