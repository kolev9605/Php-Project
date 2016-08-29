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
            if (strlen($username) < 4 || strlen($username) > 50) {
                $this->setValidationError("register-username", "Invalid username!");
            }

            $password = $_POST['register-password'];
            if (strlen($password) < 4 || strlen($password) > 50) {
                $this->setValidationError("register-password", "Invalid password!");
            }

            if ($this->formValid()) {
                $userId = $this->model->register($username, $password);
                if($userId) {
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $userId;
                    $this->addInfoMessage('Registration successful.');
                    $this->redirect("home");
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

    public function userProfile()
    {
		if($this->isLoggedIn)
		{
			$userID = $_SESSION['user_id'];
			$user = $this->model->userExists($_SERVER['QUERY_STRING']);
			$this->isOtherUser = false;
			if(isset($_SERVER['QUERY_STRING']) && isset($user) && $user['id'] != $userID)
			{
				$this->isOtherUser = true;
				$this->otherUser = $user;
				$userID = $_SERVER['QUERY_STRING'];
			}
			else 
			{
				$this->followedUsers = $this->model->getFollowedUsers($userID);
			}
			$this->userPosts = $this->model->getUserPosts($userID);
			$this->likedPosts = $this->model->getLikedPosts($userID);
		}
    }

    public function showPosts($posts, &$index, &$startIndex, $count, $userPostContainerClass, $canDeletePost)
    {
		$this->model->showPosts($posts, $index, $startIndex, $count, $userPostContainerClass, $canDeletePost);
	}
	
	public function showAvatar($id)
	{
		$this->model->showAvatar($id);
	}

    public function logout()
    {
        session_destroy();
        $this->addInfoMessage("Logout successful.");
        $this->redirect("");
    }
	
	public function pickAvatar() {
		$target_dir = "content/avatars/";
		$index = $_SESSION['user_id'];
		$imageFileType = pathinfo(basename($_FILES["avatarToUpload"]["name"]),PATHINFO_EXTENSION);
		$target_file = $target_dir . $index . "." . $imageFileType;
		$uploadOk = 1;
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$this->setValidationError("avatarToUpload", "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
			$uploadOk = 0;
		}
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"]) && strlen(basename( $_FILES["avatarToUpload"]["name"])) > 0 && $uploadOk) {
			$check = getimagesize($_FILES["avatarToUpload"]["tmp_name"]);
			if($check !== false) {
				echo $_POST["submit"];
				$uploadOk = 1;
			} else {
				$this->setValidationError("avatarToUpload", "File is not an image.");
				$uploadOk = 0;
			}
		}
		list($width, $height, $type, $attr) = getimagesize($_FILES["avatarToUpload"]["tmp_name"]);
		if($width != $height)
		{
			$this->setValidationError("avatarToUpload", "Width and height must be the same");
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$this->setValidationError("avatarToUpload", "Sorry, your file was not uploaded.");
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["avatarToUpload"]["tmp_name"], $target_file)) {
				$newTarget_dir = AVATARS;
				$result = glob ($newTarget_dir . "/" . $_SESSION['user_id'] . ".*");
				foreach($result as $file)
				{
					$currentFileType = pathinfo($file,PATHINFO_EXTENSION);
					if($currentFileType != $imageFileType)
					{
						unlink($file);
					}
				}
			} else {
				$this->setValidationError("avatarToUpload", "Sorry there was an error uploading your message");
			}
		}
		header('Location: ' . APP_ROOT. '/' . "users/userProfile");
		die;
	}
	
	public function followUser() {
		$this->model->followUser($_POST['followedUserId']);
	}
	
	public function unfollowUser() {
		$this->model->unfollowUser($_POST['followedUserId']);
	}
	
	public function isFollowingUser($followedUserID) {
		return $this->model->isFollowingUser($followedUserID);
	}
}
