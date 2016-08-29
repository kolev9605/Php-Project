<?php $this->title = 'Conversations'; 

$index = 0;
$count = count($this->conversations);

foreach($this->conversations as $conversation) : 
	if($this->model->isParticipant($conversation['id'])) : ?>
		<a class = "conversation-title" href = "<?php echo APP_ROOT ?>/conversations/conversation?<?php echo $conversation['id'] ?>">
			<b><?php echo $conversation['title'] ?></b>
		</a>
		<br>
		<b>Participants: </b>
		<?php 
			$participants = $this->getParticipantsById($conversation['id']);
			
			$participantsIndex = 0;
			$participantsCount = count($participants);
			foreach($participants as $participant)
			{
				$participantInformation = $this->model->getUserById($participant['user_id']);
				$this->model->showUsername($participantInformation);
				if($participantsIndex < $participantsCount - 1) : ?>
					| 
				<?php 
				$participantsIndex++;
				endif;
			}
		if($index < $count - 1) : ?>
			<hr class = "conversation-line">
		<?php endif;
		$index++;
	endif; 
endforeach; ?>
<hr>

<a href = "<?php echo APP_ROOT; ?>/conversations/create">Start new conversation</a>