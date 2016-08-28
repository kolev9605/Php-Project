<?php

class SearchController extends HomeController
{
    function index() {
		$searchTerm = $_SERVER['QUERY_STRING'];
		$lastPosts = $this->model->getSearchedPosts($searchTerm);
		$this->posts = $lastPosts;
    }
}
