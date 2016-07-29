<?php $this->title = 'Login'; ?>

<h1><?= htmlspecialchars($this->title) ?></h1>

<nav class="menu" id="navigation">
</nav>

<div class="user-login-block">
    <form method="post" id="login-form">
        <h1 class="title-form">Username:</h1>
        <input type="text" placeholder="Enter Username" id="login-username" name="login-username"/>
        <h1 class="title-form">Password:</h1>
        <input type="password" placeholder="Enter password" id="login-password" name="login-password"/>
        <br>
        <input class="submitButton" type="submit" id="login-button" value="Login"/>
    </form>
    <a class="form-link" href="<?= APP_ROOT ?>/users/register"> Register here</a>
</div>
