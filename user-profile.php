<?php 
if(!isset($_SESSION)){
	session_save_path("/home/instacop/tmp");
	session_start();
} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> Profile </title>
    <link type="text/css" rel="stylesheet" href="styles/style.css">
    <script src="javascripts/jquery-3.0.0.min.js"></script>
    <script src="javascripts/navigation.js"></script>
    <script src="javascripts/users.js"></script>
</head>
<body>
	<nav class="menu" id = "navigation">
	</nav>
</body>
</html>
