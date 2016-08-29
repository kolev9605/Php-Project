<?php $this->title = 'Create New Conversation'; ?>

<h1><?=htmlspecialchars($this->title)?></h1>

<div>
	<form action="create" method="post" enctype="multipart/form-data">
		Participants: 
		<div class="dropdown">
			<input type="text" name="conversation-participants" id = "conversation-participants" autocomplete="off"/>
            <div class="dropdown-content" id = "participent-dropdown-content">
			</div>
		</div>
		<br>
		<h3>Select multiple particapants by their username and separate them with the symbol ,</h3>
		<br>
		Title: <input type="text" name="conversation-title"/>
		<br>
		Conversation content:
		<br>
		<textarea rows = "5" name = "conversation-content"></textarea>
		<br>
		<input type="submit" value="Create conversation" name="submit">
	</form>
</div>