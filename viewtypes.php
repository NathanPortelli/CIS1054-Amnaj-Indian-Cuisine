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
			
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$selectedTypeId = 0;
				$isEdit = false;
				$isDelete = false;
				$i = 1;

				while($selectedTypeId === 0){
					if(isset($_POST['submit'.$i])){
						$selectedTypeId = $i;
						$isEdit = true;
						break;
					}else if(isset($_POST['delete'.$i])){
						$selectedTypeId = $i;
						$isDelete = true;
						break;
					}
					$i++;
				}
				
				$selectedType = $db->select("SELECT * FROM types WHERE typeid = ".$selectedTypeId);
				$type = array();
				$type['id'] = $selectedType[0]['typeid'];
				$type['name'] = $selectedType[0]['type'];

				if($isEdit===true){	
					echo $twig->render("edittype.html", ['type' => $type]);
				}else if($isDelete===true){
					$dishes = $db->select("SELECT dishid FROM menu WHERE dishtype=".$selectedTypeId);

					for($j = 0; $j < sizeof($dishes); $j++){
						$delAllergy = $db->query("DELETE FROM hasallergies WHERE dishID=".$db->quote($dishes[$j]['dishid']));
					}

					$delDishes = $db->query("DELETE FROM menu WHERE dishtype=".$selectedTypeId);

					$sql = $db->query("DELETE FROM types WHERE typeid = ".$db->quote($type['id']));

					header("Location: admin.php?success=true");
					exit();
				}
			}else{
				echo $twig->render("viewtypes.html", ['types' => $types]);
			}
		}else{
			header("Location: index.php", true, 403);
			exit();
		}
	} else {
		header("Location: signin.php");
		exit();
	}