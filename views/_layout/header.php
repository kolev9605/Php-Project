<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?= APP_ROOT ?>/content/style.css"/>
    <script src="<?= APP_ROOT ?>/content/scripts/jquery-3.0.0.min.js"></script>
    <script src="<?= APP_ROOT ?>/content/scripts/bootstrap.min.js"></script>
    <script src="<?= APP_ROOT ?>/content/scripts/bootstrap-filestyle.min.js"></script>
    <script src="<?= APP_ROOT ?>/content/scripts/scripts.js"></script>
    <title><?php if (isset($this->title)) echo htmlspecialchars($this->title) ?></title>
</head>

<body>
<header>
    <div class="menuItem" id="logo">
        <a id="logoText" href="<?= APP_ROOT ?>">
            Hot Page |
        </a>
        <a id="logoText" href="<?= APP_ROOT ?>/home/fresh">
            Fresh Page
        </a>
    </div>
    <div class="menuItem" id="searchBar">
		<input type="text" class = "search" id="search" placeholder="Search"/>
        <img id="searchButton" src="<?= APP_ROOT ?>/content/images/search-button.png" 
			onclick = 'showSearch("<?php echo APP_ROOT; ?>")'>
    </div>
    <div class="menuItem" id="searchBar">
		<div class="dropdown">
			<input type="text" class = "search"  id="searchByUsername" placeholder="Search by username"/>
			<div class="dropdown-content" id = "search-dropdown-content">
			</div>
		</div>
        <img id="searchButton" src="<?= APP_ROOT ?>/content/images/search-button.png" 
			onclick = 'showSearch("<?php echo APP_ROOT; ?>")'>
    </div>
    <div class="menuItem" id="menu">
        <div class="dropdown">
            <img class="icon" src="<?= APP_ROOT ?>/content/images/my-profile-icon.png">
            <div class="dropdown-content" id = "menu-dropdown-content">
				<div class="menuItem">
					<?php if ($this->isLoggedIn) : ?>
						<div id="logged-in-info">
							<div class = "dropdown-item">
								<a href = "<?=APP_ROOT?>/posts/create">Create New Post</a>
							</div>
							<div class = "dropdown-item">
								<a href="<?=APP_ROOT?>/users/userProfile">User Profile</a>
							</div>
							<div class = "dropdown-item">
								<a href="<?=APP_ROOT?>/conversations">Conversations</a>
							</div>
							<div class = "dropdown-item">
								<form method="post" action="<?=APP_ROOT?>/users/logout">
									<input id = "logout-button" type="submit" value="Logout"/>
								</form>
							</div>
						</div>
					<?php else: ?>
						<div class = "dropdown-item">
							<a href="<?=APP_ROOT?>/users/login">Login</a>
						</div>
						<div class = "dropdown-item">
							<a href="<?=APP_ROOT?>/users/register">Register</a>
						</div>
					<?php endif; ?>
				</div>
            </div>
        </div>
    </div>
    <hr>
</header>
