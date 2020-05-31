<?php
require_once 'dbwrapper.php';
require_once 'bootstrap.php';
require_once 'header.php';
require_once 'handleimages.php';
require_once 'validate.php';

if($_SESSION['usergroup'] == 1){
	$db = new Db();
	$val = new Validate();
	$himg = new HandleImages();
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$name = $_POST["aTypeName"];
		$photo = $_FILES["aTypePhoto"];
		$validations = array();
		$formvalues = array();

		$vname = $val->validateString($name, 20);
		// echo "name: ".$name;
		if($name != $vname){
			$validations['name'] = $vname;
		}
		
		if($photo['size'] !== 0){
			$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], 'icons');

			if($upload === 0){
				$validations['photo'] = "Invalid file extension";
			}else if($upload === 1){
				$validations['photo'] = "Upload Error";
			}else if($upload === 2){
				$validations['photo'] = "File too big";
			}else if($upload === 3){
				$validations['photo'] = "Upload Error";
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
	header("Location: index.php");
	exit();
}

require_once 'footer.php';
?>