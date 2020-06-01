<?php
require_once 'dbwrapper.php';
require_once 'bootstrap.php';
require_once 'resources/includes/handleimages.php';
require_once 'resources/includes/validate.php';
session_start();

if($_SESSION['usergroup'] == 1){
	$db = new Db();
	$val = new Validate();
	$himg = new HandleImages();
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$name = $_POST["aTeamName"];
		$role = $_POST["aTeamRole"];
		$desc = $_POST["aTeamDescription"];
		$photo = $_FILES["aTeamPhoto"];
		$validations = array();
		$formvalues = array();

		$vname = $val->validateString($name, 40);
		
		if($name != $vname){
			$validations['name'] = $vname;
		}

		$vdesc = $val->validateArea($desc, 1000);
		
		if($desc != $vdesc){
			$validations['desc'] = $vdesc;
		}

		$vrole = $val->validateString($role, 40);
		
		if($role != $vrole){
			$validations['role'] = $vrole;
		}
		
		if($photo['size'] !== 0){
			$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], 'staffimages');

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
			$validations['photo'] = "Please upload a photo";
		}

		if(!empty($validations)){
			$formvalues['name'] = $name;
			$formvalues['desc'] = $desc;
			$formvalues['role'] = $role;
			$formvalues['photo'] = $photo;

			echo $twig->render("addmember.html", ['validations' => $validations, 'formvalues' => $formvalues]);
		}else{
			$sql = $db->query("INSERT INTO team_details (name, role, description, photo) VALUES (".$db->quote($name).", ".$db->quote($role).", ".$db->quote($desc).", ".$db->quote($upload).")");
			
			header("Location: admin.php?success=true");
			exit();
		}
	}else{
		echo $twig->render("addmember.html");
	}
}else{
	header("Location: index.php");
	exit();
}

