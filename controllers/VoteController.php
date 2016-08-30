<?php

class VoteController extends BaseController
{
    function onInit() {
		$post = $_POST['voteObject'];
		$loggedUser = $_POST['loggedUser'];
		$isUpVote = true;
		if($_POST['isUpVote'] == "false")
		{
			$isUpVote = false;
		}
		$vote = $this->model->getVote($post, $loggedUser);
		$voteChange = 1;
		if(!isset($vote))
		{
			$this->model->createVote($post, $loggedUser, $isUpVote);
		}
		else
		{
			$currentVoteIsUpVote = $vote['is_positive'];
		}
		
		$removeVote = false;
		if($isUpVote)
		{
			if(isset($currentVoteIsUpVote))
			{
				if($currentVoteIsUpVote)
				{
					$removeVote = true;
					$voteChange = -1;
				}
				else
				{
					$this->model->changeVote($vote['id'], 1);
					$voteChange = 2;
				}
			}
			else if($loggedUser['is_admin'])
			{
				$this->model->moveToHot($post);
			}
		}
		else
		{
			$voteChange = -1;
			if(isset($currentVoteIsUpVote))
			{
				if($currentVoteIsUpVote)
				{
					$this->model->changeVote($vote['id'], 0);
					$voteChange = -2;
				}
				else
				{
					$removeVote = true;
					$voteChange = 1;
				}
			}
		}
		
		$newVotes = $this->model->getPostVotes($post['id']) + $voteChange;
		$this->model->vote($post, $isUpVote, $newVotes);
		if($removeVote)
		{
			$this->model->removeVote($post, $loggedUser);
		}
		
		echo $newVotes . "\n";
    }
}
