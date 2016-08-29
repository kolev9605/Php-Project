<?php

class ConversationCommentController extends BaseController
{
    function onInit() {
		$conversation = $_POST['conversation'];
		$content = $_POST['content'];
		if (strlen($content) < 1) {
			$this->setValidationError("conversationCommentContent", "Comment cannot be empty");
		}
		
		$this->model->addComment($conversation, $content);
    }
}
