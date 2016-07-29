<?php 
if(!isset($_SESSION)){
	session_save_path("/home/instacop/tmp");
	session_start();
} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> Register </title>
    <link type="text/css" rel="stylesheet" href="styles/style.css">
    <link type="text/css" rel="stylesheet" href="styles/form-style.css">
    <script src="javascripts/jquery-3.0.0.min.js"></script>
    <script src="javascripts/users.js"></script>
    <script src="javascripts/navigation.js"></script>
</head>
<body>
	<nav class="menu" id = "navigation">
	</nav>
	<div class = "user-login-block">
		<form id = "register-form">
			<h1 id = "register-information">Register and join your friends by sharing pictures and commenting.</h1>
			<hr id = "register-line">
			<h2 class = "title-form">Username:</h2>
			<input type = "text" value "" placeholder = "Enter Username" id = "register-username" />
			<h2 class = "title-form">Password:</h2>
			<input type = "password" value "" placeholder = "Enter password" id = "register-password" />
			<h2 class = "title-form">Confirm Password:</h2>
			<input type = "password" value "" placeholder = "Confirm password" id = "confirmed-password" />
			<br>
			<input class = "submitButton" type = "submit" id = "register-button" value = "Register" />
		</form>
		<a class = "form-link" href = "login.php"> Login here</a>
	</div>
</body>
</html>
