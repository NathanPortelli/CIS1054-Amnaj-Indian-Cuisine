<?php
	require_once 'dbwrapper.php';
	require_once 'bootstrap.php';
	require_once 'resources/includes/handleimages.php';
	require_once 'resources/includes/validate.php';
	session_start();

	if (isset($_SESSION['usergroup'])){
		if($_SESSION['usergroup'] == 1){
			$db = new Db();
			$val = new Validate();
			$himg = new HandleImages();
			
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aTypeName']) && isset($_FILES['aTypePhoto'])){
				$name = $_POST["aTypeName"];
				$photo = $_FILES["aTypePhoto"];
				$validations = array();
				$formvalues = array();

				$vname = $val->validateString($name, 20);
				
				if($name != $vname){
					$validations['name'] = $vname;
				}
				
				if($photo['size'] !== 0){
					$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], 'icons');

					if(strpos($upload, $photo['name']) === false){
						$validations['photo'] = $upload;
					}
				}else{
					$validations['photo'] = "Please upload an image";
				}

				if(!empty($validations)){
					$formvalues['name'] = $name;
					$formvalues['photo'] = $photo;

					echo $twig->render("addtype.html", ['validations' => $validations, 'formvalues' => $formvalues]);
				}else{
					$sql = $db->query("INSERT INTO types (type, typeimg) VALUES (".$db->quote($name).", ".$db->quote($upload).")");
					
					header("Location: admin.php?success=true");
					exit();
				}
			}else{
				echo $twig->render("addtype.html");
			}
		}else{
			header("Location: index.php", true, 403);
			exit();
		}
	} else {
		header("Location: signin.php");
		exit();
	}