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
		$this->model->showPosts($startIndex, $count, $index, $this->posts);
	} 
}
