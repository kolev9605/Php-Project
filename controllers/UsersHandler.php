<?php
require_once 'UsersController.php';

if (isset($_POST['action'])) {
     $usersController= new UsersController("users", $_POST['action']);
	switch ($_POST['action']) {
	case 'login':
    	echo "0";
	    $usersController->login($_POST['username'], $_POST['password']);
	    break;
	case 'register':
	    $usersController->register($_POST['username'], $_POST['password'], $_POST['confirmedPassword']);
	    break;
	}
}