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
			
			$target_dir = "content/uploads/";
			$index = 0;
			$target_file = $target_dir . $index . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			while (file_exists($target_file)) {
				$index++;
				$target_file = $target_dir . $index . basename($_FILES["fileToUpload"]["name"]);
			}
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"]) && strlen(basename( $_FILES["fileToUpload"]["name"])) > 0) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo $_POST["submit"];
					$uploadOk = 1;
				} else {
					$this->setValidationError("imageLocation", "File is not an image.");
					$uploadOk = 0;
				}
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$this->setValidationError("imageLocation", "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$this->setValidationError("imageLocation", "Sorry, your file was not uploaded.");
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$imageSrc = $index . basename( $_FILES["fileToUpload"]["name"]);
					if($this->formValid()) {
						$userId = $_SESSION['user_id'];
						if($this->model->create($title, $imageSrc, $userId)) {
							$this->addInfoMessage("Post created.");
							$this->redirect("home");
						} else {
							$this->addErrorMessage("Error: cannot create post.");
						}
					}
				} else {
					$this->setValidationError("imageLocation", "Sorry there was an error uploading your message");
				}
			}
		}
    }
	
	public function edit(int $id) {
	
    }
	
	public function delete(int $id) {
	
    }
}