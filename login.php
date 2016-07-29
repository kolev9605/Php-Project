<?php 
if(!isset($_SESSION)){
	session_save_path("/home/instacop/tmp");
	session_start();
} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> Login </title>
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
		<form id = "login-form">
			<h1 class = "title-form">Username:</h1>
			<input type = "text" value "" placeholder = "Enter Username" id = "login-username" />
			<h1 class = "title-form">Password:</h1>
			<input type = "password" value "" placeholder = "Enter password" id = "login-password" />
			<br>
			<input class = "submitButton" type = "submit" id = "login-button" value = "Login" />
		</form>
		<a class = "form-link" href = "register.php"> Register here</a>
	</div>
</body>
</html>
