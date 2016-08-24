<?php

class VoteController extends BaseController
{
    function onInit() {
		$post = $_POST['post'];
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
		
		if($isUpVote)
		{
			if(isset($currentVoteIsUpVote))
			{
				if($currentVoteIsUpVote)
				{
					$voteChange = 0;
				}
				else
				{
					$this->model->changeVote($vote['id'], 1);
					$voteChange = 2;
				}
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
					$voteChange = 0;
				}
			}
		}
		
		$newVotes = $this->model->getPostVotes($post['id']) + $voteChange;
		$this->model->vote($post, $isUpVote, $newVotes);
		echo $newVotes . "\n";
    }
}
