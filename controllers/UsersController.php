<?php
include 'BaseController.php';

class UsersController extends BaseController
{

    public function register(string $username, string $password, string $confirmedPassword)
    {
    	if($this->isPost) 
    	{
    		if(strlen($username) < 2 || strlen($username) > 50) 
    		{
    			$this->setValidationError("username", "Invalid username!");
    		}
    		if(strlen($password) < 2 || strlen($password) > 50) 
    		{
    			$this->setValidationError("password", "Invalid password!");
		}
    		if($password != $confirmedPassword) 
    		{
    			$this->setValidationError("confirmedPassword", "Passwords do not match");
    		}    	
	    	if($this->formValid())
	    	{
	    		$userId = $this->model->register($username, $password);
	    		if($userId)
	    		{
	    			$_SESSION['username'] = $username;
	    			$_SESSION['user_id'] = $userId;
	    			$this->addInfoMessage("Registration successful.");
	    		}
	    		else
	    		{
	    			$this->addErrorMessage("Error: user registration failed!");
	    		}
	    	}
    	}
    }

    public function login(string $username, string $password)
    {
    	if($this->isPost) {
    		$loggedUserId= $this->model->login($username, $password);
    		if($loggedUserId) {
    			$_SESSION['username'] = $username;
    			$_SESSION['user_id'] = $loggedUserId;
    			$isLoggedIn = true;
    			$this->addInfoMessage("Login successful.");
    		}
    		else {
    			$this->addErrorMessage("Error: login failed!");
    		}
    	}
    }

    public function logout()
    {
		// TODO: your user logout functionality will come here ...
    }
}
