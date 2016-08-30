<?php

class SearchController extends HomeController
{
    function index() {
		$searchTerm = $_GET['searchTerm'];
		$username = $_GET['searchUsername'];
		if(strlen($searchTerm) > 0 && strlen($username) == 0)
		{
			$lastPosts = $this->model->getSearchedPosts($searchTerm);
			$this->posts = $lastPosts;
		}
		if(strlen($username) > 0)
		{
			$this->foundUser = $this->model->getUserByUsername($username);
		}
		if(strlen($searchTerm) == 0 && strlen($username) > 0)
		{
			$lastPosts = $this->model->getUserPosts($this->foundUser['id']);
			$this->posts = $lastPosts;
		}
		if(strlen($searchTerm) > 0 && strlen($username) > 0)
		{
			$lastPosts = $this->model->getSearchedPostsFromUser($searchTerm, $this->foundUser['id']);
			$this->posts = $lastPosts;
		}
    }
}
