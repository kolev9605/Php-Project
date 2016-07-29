<?php 
if(!isset($_SESSION)){
	session_save_path("/home/instacop/tmp");
	session_start();
} ?>
<div class="menuItem" id="logo">
        <a id="logoText" href="index.php">
            Our Teamwork project
        </a>
</div>
<div class="menuItem" id="searchBar">
        <input type="text" id="search" placeholder="Search"/>
        <a href="#"><img id="searchButton" src="images/search-button.png"></a>
</div>
<div class="menuItem" id="menu">
    	<div class="dropdown">
		<img class="icon" src="images/my-profile-icon.png">
		<div class="dropdown-content">
			<?php require_once('autoloader.php');
   			if ($_SESSION['isLoggedIn']) : ?>
				<span class = "user" id = "userProfile">
					<a href="user-profile.php">User profile</a>
					<br>
					<a href="#" id = "signOutButton">Sign out</a>
				</span>
    			<?php else: ?>
				<span class = "guest" id = "guestProfile">
					<a href="login.php">Sign in</a>
					<br>
					<a href="register.php">Sign up</a>
				</span>
    			<?php endif; ?>
		</div>
    	</div>
</div>
	
<hr>