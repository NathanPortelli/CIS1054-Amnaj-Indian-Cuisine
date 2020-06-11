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

			$types = $db->select("SELECT * FROM types");
			$allergies = $db->select("SELECT * FROM allergies");
			
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eDishName']) && isset($_POST['typeSelect']) && isset($_POST['eDishIngredients']) && isset($_POST['eDishDescription']) && isset($_POST['eDishServing']) && isset($_FILES['eDishPhoto']) && isset($_POST['eDishPrice']) && isset($_POST['allSelect']) && isset($_POST['eDishId'])){
				$name = $_POST["eDishName"];
				$type = $_POST["typeSelect"];
				$ing = $_POST["eDishIngredients"];
				$desc = $_POST["eDishDescription"];
				$serving = $_POST["eDishServing"];
				$photo = $_FILES["eDishPhoto"];
				$price = $_POST["eDishPrice"];
				$all = $_POST["allSelect"];
				$id = $_POST['eDishId'];
				$validations = array();
				$formvalues = array();
				$typeId = array();
				$photoCheck = true;

				$vid = $val->validateInt($id, 3);
				$idCheck = $db->select("SELECT dishid FROM menu WHERE dishid = ".$db->quote($id));
				
				if($id != $vid){
					$validations['id'] = $vid;
				}else if($idCheck === false){
					$validations['id'] = "Please enter an existing id";
				}

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
					$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], "dishes");

					if(strpos($upload, $photo['name']) === false){
						$validations['photo'] = $upload;
					}
				}else{
					$photoCheck = false;
				}

				if(!isset($type)){
					$validatons['type'] = "Please select a dish type";
				}else{
					$typeId = $db->select("SELECT typeid FROM types WHERE type = ".$db->quote($type));
				}

				if(!empty($validations)){
					$formvalues['id'] = $id;
					$formvalues['name'] = $name;
					$formvalues['type'] = $type;
					$formvalues['desc'] = $desc;
					$formvalues['price'] = $price;
					$formvalues['serving'] = $serving;
					$formvalues['ing'] = $ing;
					$formvalues['photo'] = $photo;

					echo $twig->render("editdish.html", ['types' => $types, 'allergies' => $allergies, 'validations' => $validations, 'formvalues' => $formvalues]);
				}else{

					$sql = $db->query("UPDATE menu SET dishtype=".$db->quote($type).", dishname=".$db->quote($name).", dishdesc=".$db->quote($desc).", price=".$db->quote($price).", ingredients=".$db->quote($ing).", serving=".$db->quote($serving)." WHERE dishid=".$db->quote($id));

					if($photoCheck === true){
						$updatePhoto = $db->query("UPDATE menu SET dishphoto=".$db->quote($upload)." WHERE dishid=".$db->quote($id));
					}

					if($all[0] != "None"){
						$delIds = $db->query("DELETE FROM hasallergies WHERE dishID=".$db->quote($id));
						for($i = 0; $i<sizeof($all); $i++){
							$createAllergy = $db->query("INSERT INTO hasallergies (allerID, dishID) VALUES (".$db->quote($all[$i]).", ".$db->quote($id).")");
						}
					}

					header("Location: viewdishes.php?success=true");
					exit();
				}
			}else{
				echo $twig->render("editdish.html", ['types' => $types, 'allergies' => $allergies]);
			}
		}else{
			header("Location: index.php", true, 403);
			exit();
		}
	} else {
		header("Location: signin.php");
		exit();
	}