<?php

class PostsController extends BaseController
{
    function onInit() {
		$this->authorize();
    }
	
	public function index() {
		$this->posts = $this->model->getAll();
    }
	
	public function create() {
		if($this->isPost) {
			$title = $_POST['post-title'];
			if(strlen($title) < 1) {
				$this->setValidationError("post-title", "Title cannot be empty!");
			}
			
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo $_POST["submit"];
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
			
			$imageSrc = basename( $_FILES["fileToUpload"]["name"]);
			if($this->formValid()) {
				$userId = $_SESSION['user_id'];
				if($this->model->create($title, $imageSrc, $userId)) {
					$this->addInfoMessage("Post created.");
					$this->redirect("posts");
				} else {
					$this->addErrorMessage("Error: cannot create post.");
				}
			}
		}
    }
	
	public function edit(int $id) {
	
    }
	
	public function delete(int $id) {
	
    }
}
