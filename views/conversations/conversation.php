<?php $this->title = 'Conversations';

foreach($this->comments as $comment)
{
	$this->showComment($comment);
}  ?>

<div>
	<textarea class = "commentField" type="text" rows = "5" id = "conversationCommentContent" name = "conversationCommentContent" placeholder = "Add your comment here"></textarea>
	<br>
	<button class="commentSubmit" 
	onclick='addConversationComment(<?php echo json_encode($this->model->getById($_SERVER['QUERY_STRING'])); ?> )'>Comment</button>
</div>

<hr>