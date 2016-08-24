<?php

class CommentController extends BaseController
{
    function onInit() {
		$post = $_POST['post'];
		$content = $_POST['content'];
		if (strlen($content) < 1) {
			$this->setValidationError("commentContent", "Comment cannot be empty");
		}
		
		$this->model->addComment($post, $content);
    }
}
