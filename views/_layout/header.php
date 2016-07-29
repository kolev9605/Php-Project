<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?= APP_ROOT ?>/content/style.css"/>
    <script src="<?= APP_ROOT ?>/content/scripts/jquery-3.0.0.min.js"></script>
    <script src="<?= APP_ROOT ?>/content/scripts/scripts.js"></script>
    <title><?php if (isset($this->title)) echo htmlspecialchars($this->title) ?></title>
</head>

<body>
<header>
    <div class="menuItem" id="logo">
        <a id="logoText" href="<?= APP_ROOT ?>">
            Our Teamwork project
        </a>
    </div>
    <div class="menuItem" id="searchBar">
        <input type="text" id="search" placeholder="Search"/>
        <a href="#"><img id="searchButton" src="<?= APP_ROOT ?>/content/images/search-button.png"></a>
    </div>
    <div class="menuItem" id="menu">
        <div class="dropdown">
            <img class="icon" src="<?= APP_ROOT ?>/content/images/my-profile-icon.png">
            <div class="dropdown-content">
            </div>
        </div>
    </div>
    <div class="menuItem">
        <?php if ($this->isLoggedIn) : ?>
        <!-- The user actions we will add later on-->
        <?php else: ?>
            <a href="<?=APP_ROOT?>/users/login">Login</a>
            <a href="<?=APP_ROOT?>/users/register">Register</a>
        <?php endif; ?>

        <?php if ($this->isLoggedIn) : ?>
            <div id="logged-in-info">
                <span>Hello, <b><?=htmlspecialchars($_SESSION['username'])?></b></span>
                <form method="post" action="<?=APP_ROOT?>/users/logout">
                    <input type="submit" value="Logout"/>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <hr>
</header>