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
	
	$dishes = $db->select("SELECT * FROM menu");
	$allergies = $db->select("SELECT * FROM allergies");
	$types = $db->select("SELECT * FROM types");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$selectedDishId = 0;
		$isEdit = false;
		$isDelete = false;
		$i = 1;
		
		while($selectedDishId === 0){
			if(isset($_POST['submit'.$i])){
				$selectedDishId = $i;
				$isEdit = true;
				break;
			}else if(isset($_POST['delete'.$i])){
				$selectedDishId = $i;
				$isDelete = true;
				break;
			}
			$i++;
		}
		$selectedDish = $db->select("SELECT * FROM menu WHERE dishid = ".$selectedDishId);

		$dish = array();
		$dish['id'] = $selectedDish[0]['dishid'];
		$dish['name'] = $selectedDish[0]['dishname'];
		$dish['type'] = $selectedDish[0]['dishtype'];
		$dish['desc'] = $selectedDish[0]['dishdesc'];
		$dish['price'] = $selectedDish[0]['price'];
		$dish['serving'] = $selectedDish[0]['serving'];
		$dish['ing'] = $selectedDish[0]['ingredients'];
		$dish['photo'] = $selectedDish[0]['dishphoto'];

		if($isEdit){	
			echo $twig->render("editdish.html",['dish' => $dish, 'allergies' => $allergies, 'types' => $types]);

		}else if($isDelete){
			$delAllergy = $db->query("DELETE FROM hasallergies WHERE dishID=".$db->quote($dish['id']));
			$sql = $db->query("DELETE FROM menu WHERE dishid = ".$db->quote($dish['id']));
			header("Location: viewdishes.php?success=true");
			exit();
		}
	}else{
		echo $twig->render("viewdishes.html", ['dishes' => $dishes]);
	}
}else{
	header("Location: index.php");
	exit();
}