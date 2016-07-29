<?php

class UsersController extends BaseController
{
    public function index()
    {
        $this->authorize();
        $this->users = $this->model->getAll();
    }

    public function register()
    {
        if ($this->isPost) {
            $username = $_POST['register-username'];
            if (strlen($username) < 2 || strlen($username) > 50) {
                $this->setValidationError("register-username", "Invalid username!");
            }

            $password = $_POST['register-password'];
            if (strlen($username) < 2 || strlen($username) > 50) {
                $this->setValidationError("register-password", "Invalid password!");
            }

            $full_name = $_POST['full-name'];
            if (strlen($username) > 200) {
                $this->setValidationError("full-name", "Invalid full name!");
            }

            if ($this->formValid()) {
                $userId = $this->model->register($username, $password, $full_name);
                if($userId) {
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $userId;
                    $this->addInfoMessage('Registration successful.');
                    $this->redirect("");
                } else {
                    $this->addErrorMessage("Error: user registration failed.");
                }
            }
        }
    }

    public function login()
    {
        if ($this->isPost) {
            $username = $_POST['login-username'];
            $password = $_POST['login-password'];
            $loggedUserId = $this->model->login($username, $password);
            if ($loggedUserId) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $loggedUserId;
                $this->addInfoMessage("Login successful.");

                return $this->redirect("");
            } else {
                $this->addErrorMessage("Error. Login failed.");
            }
        }
    }

    public function logout()
    {
        session_destroy();
        $this->addInfoMessage("Logout successful.");
        $this->redirect("");
    }
}
