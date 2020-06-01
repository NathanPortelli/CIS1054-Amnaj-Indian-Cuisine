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

	$types = $db->select("SELECT * FROM types");
	$allergies = $db->select("SELECT * FROM allergies");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$name = $_POST["aDishName"];
		$type = $_POST["typeSelect"];
		$ing = $_POST["aDishIngredients"];
		$desc = $_POST["aDishDescription"];
		$serving = $_POST["aDishServing"];
		$photo = $_FILES["aDishPhoto"];
		$price = $_POST["aDishPrice"];
		$all = $_POST["allSelect"];
		$validations = array();
		$formvalues = array();
		$typeId = "";

		$vname = $val->validateString($name, 100);
		
		if($name != $vname){
			$validations['name'] = $vname;
		}

		$ving = $val->validateArea($ing, 250);
		
		if($ing != $ving){
			$validations['ing'] = $ving;
		}

		$vdesc = $val->validateArea($desc, 200);
		
		if($desc != $vdesc){
			$validations['desc'] = $vdesc;
		}

		$vserving = $val->validateInt($serving, 3);
		
		if($serving != $vserving){
			$validations['serving'] = $vserving;
		}

		$vprice = $val->validateDouble($price, 7);
		
		if($price != $vprice){
			$validations['price'] = $vprice;
		}
		
		if($photo['size'] !== 0){
			$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], 'dishes');

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

		if(empty($type)){
			$validations['type'] = "Please select a dish type";
		}else{
			$typeId = $db->select("SELECT typeid FROM types WHERE type = ".$db->quote($type));
		}

		if(!empty($validations)){
			$formvalues['name'] = $name;
			$formvalues['type'] = $type;
			$formvalues['desc'] = $desc;
			$formvalues['price'] = $price;
			$formvalues['serving'] = $serving;
			$formvalues['ing'] = $ing;
			$formvalues['photo'] = $photo;

			echo $twig->render("adddish.html", ['types' => $types, 'allergies' => $allergies, 'validations' => $validations, 'formvalues' => $formvalues]);
		}else{
			$sql = $db->query("INSERT INTO menu (dishtype, dishname, dishdesc, price, dishphoto, ingredients, serving) VALUES (".$db->quote($typeId[0]['typeid']).", ".$db->quote($name).", ".$db->quote($desc).", ".$db->quote($price).", ".$db->quote($upload).", ".$db->quote($ing).", ".$db->quote($serving).")");

			if($all[0] != "None"){
				$dishIdS = $db->select("SELECT  MAX(dishid) AS dishid FROM menu");
		
				for($i = 0; $i<sizeof($all); $i++){
					$createAllergy = $db->query("INSERT INTO hasallergies (allerID, dishID) VALUES (".$db->quote($all[$i]).", ".$db->quote($dishIdS[0]['dishid']).")");
				}
			}

			header("Location: admin.php?success=true");
			exit();
		}

	}else{
		echo $twig->render("adddish.html", ['types' => $types, 'allergies' => $allergies]);
	}
}else{
	header("Location: index.php");
	exit();
}
