<?php $this->title = 'Register New User'; ?>

<h1><?= htmlspecialchars($this->title) ?></h1>

<nav class="menu" id="navigation">
</nav>
<div class="user-login-block">
    <form method="post" id="register-form">
        <h1 id="register-information">Register and join your friends by sharing pictures and commenting.</h1>
        <hr id="register-line">
        <h2 class="title-form">Username:</h2>
        <input type="text" placeholder="Enter Username" id="register-username" name="register-username"/>
        <h2 class="title-form">Password:</h2>
        <input type="password" placeholder="Enter password" id="register-password" name="register-password"/>
        <h2 class="title-form">Confirm Password:</h2>
        <input type="password" placeholder="Confirm password" id="confirmed-password" name="confirmed-password"/>
        <h2 class="title-form">Full name:</h2>
        <input type="text" placeholder="Full name" id="full-name" name="full-name"/>

        <input type="submit" class="submitButton" id="register-button" value="Register"/>
    </form>
    <a class="form-link" href="<?= APP_ROOT ?>/users/login"> Login here</a>
</div>