<?php
require_once '../../dbwrapper.php';
require_once '../../handleimages.php';
$db = new Db();
$himg = new HandleImages();

$checkType = "";

if(isset($_POST['aDishSubmit'])){
	
	$name = $_POST["aDishName"];
	$type = $_POST["aDishType"];
	$ing = $_POST["aDishIngredients"];
	$desc = $_POST["aDishDescription"];
	$serving = $_POST["aDishServing"];
	$photo = $_POST["aDishPhoto"];
	$price = $_POST["aDishPrice"];
	$allId = $_POST["aDishAllId"];

	$validTypes = $db->select("SELECT typeid FROM types");
	for($i = 0; $i<sizeof($validTypes); $i++){
		if($type == $validTypes[$i]['typeid']){
			$checkType = true;
			break;
		}else{
			$checkType = false;
		}
	}

	if(empty($name) || empty(trim($type)) || empty($ing) || empty($desc) || empty($photo) || empty(trim($price)) || empty(trim($serving))){

	}else if(strlen($desc) > 200 || strlen($ing) > 200){
		header("Location: ../../admin.php?error=tooManyChars");
		exit();

	}else if($checkType === false){
		header("Location: ../../admin.php?error=invalidType");
		exit();

	}else{
		$sql = $db->query("INSERT INTO menu (dishtype, dishname, dishdesc, price, dishphoto, ingredients, serving) VALUES (".$db->quote($type).", ".$db->quote($name).", ".$db->quote($desc).", ".$db->quote($price).", ".$db->quote($photo).", ".$db->quote($ing).", ".$db->quote($serving).")");

		if(!empty($allId)){
			$dishIdS = $db->select("SELECT dishid FROM menu WHERE dishtype =".$db->quote($type)." AND dishname =".$db->quote($name)." AND dishdesc =".$db->quote($desc)." AND price =".$db->quote($price)." AND dishphoto =".$db->quote($photo)." AND ingredients =".$db->quote($ing)." AND serving =".$db->quote($serving)." ");

			$dishId = "";

			for($i = 0; $i<sizeof($dishIdS); $i++){
				$dishId = $dishIdS[$i]['dishid'];
				if($dishId !== NULL){
					break;
				}
			}
			

			$allergies = explode(',', $allId);

			for($i = 0; $i<sizeof($allergies); $i++){
				$createAllergy = $db->query("INSERT INTO hasallergies (allerID, dishID) VALUES (".$db->quote($allergies[$i]).", ".$db->quote($dishId).")");
			}
		}
		
			header("Location: ../../admin.php?error=cool");
			exit();
	}

}else if(isset($_POST['eDishSubmit'])){
	$id = $_POST["eDishId"];
	$name = $_POST["eDishName"];
	$type = $_POST["eDishType"];
	$ing = $_POST["eDishIngredients"];
	$desc = $_POST["eDishDescription"];
	$serving = $_POST["eDishServing"];
	$photo = $_POST["eDishPhoto"];
	$price = $_POST["eDishPrice"];
	$allIdO = $_POST["eDishAllIdO"];
	$allIdN = $_POST["eDishAllIdN"];

	$validTypes = $db->select("SELECT typeid FROM types");
	for($i = 0; $i<sizeof($validTypes); $i++){
		if($type == $validTypes[$i]['typeid']){
		$checkType = true;
		}
	}
	$checkType = false;

	if(empty($id)){
		header("Location: ../../admin.php?error=emptyID");
		exit();
	}else{
		if(!empty($name)){
			$sql = $db->query("UPDATE menu SET dishname = ".$db->quote($name)." WHERE menu.dishid = ".$db->quote($id));
		}
		if(!empty(trim($type))){
			if($checkType === false){
				header("Location: ../../admin.php?error=invalidType");
				exit();
			}else{
				$sql = $db->query("UPDATE menu SET dishname = ".$db->quote($type)." WHERE menu.dishid = ".$db->quote($id));
			}
		}
		if(!empty($dishdesc)){
			if(strlen($desc) < 200){
				header("Location: ../../admin.php?error=tooManyChars");
				exit();
			}else{
				$sql = $db->query("UPDATE menu SET dishdesc = ".$db->quote($desc)." WHERE menu.dishid = ".$db->quote($id));
			}
		}
		if(!empty(trim($price))){
			if($price < 0){
				header("Location: ../../admin.php?error=negNum");
				exit();
			}else{
				$sql = $db->query("UPDATE menu SET price = ".$db->quote($price)." WHERE menu.dishid = ".$db->quote($id));
			}
		}
		if(!empty($ingredients)){
			if(strlen($ingredients) < 200){
				header("Location: ../../admin.php?error=tooManyChars");
				exit();
			}else{
				$sql = $db->query("UPDATE menu SET ingredients = ".$db->quote($ing)." WHERE menu.dishid = ".$db->quote($id));
			}
		}
		if(empty(trim($serving))){
			if($serving < 0){
				header("Location: ../../admin.php?error=negNum");
			}else{
				$sql = $db->query("UPDATE menu SET serving = ".$db->quote($serving)." WHERE menu.dishid = ".$db->quote($id));
			}
		}
		if(!empty($photo)){
			$sql = $db->query("UPDATE menu SET dishphoto = ".$db->quote($photo)." WHERE menu.dishid = ".$db->quote($id));
		
		}
		if(!empty(trim($allIdN)) && !empty(trim($allIdO))){
			$sql = $db->query("UPDATE hasallergies SET allerID = ".$db->quote($allIdN)." WHERE dishID = ".$db->quote($id)." AND allerID = ".$db->quote($allIdO)." ");
		}
		
		header("Location: ../../admin.php?error=cool");
		exit();

	}

}else if(isset($_POST['rDishSubmit'])){
	$id = $_POST["rDishId"];

	if(empty($id)){
		header("Location: ../../admin.php?error=emptyFields");
	}else{
		$remFav = $db->query("DELETE FROM favourites WHERE dishID = ".$db->quote($id));
		$remAllergy = $db->query("DELETE FROM hasallergies WHERE dishID = ".$db->quote($id));

		$sql = $db->query("DELETE FROM menu WHERE dishid = ".$db->quote($id));
	}

	header("Location: ../../admin.php?error=cool");
	exit();


}else if(isset($_POST['aTypeSubmit'])){
	$name = $_POST['aTypeName'];
	$icon = $_POST['aTypeIcon'];

	if(empty($name) || empty($icon)){
		header("Location: ../../admin.php?error=emptyFields");
		exit();
	}else{
		$sql = $db->query("INSERT INTO types (type, typeimg) VALUES (".$db->quote($name).",".$db->quote($icon).")");
		if(!sql){
			header("Location: ../../admin.php?error=SQLerror");
			exit();
		}else{
			header("Location: ../../admin.php?error=cool");
			exit();
		}
	}


}else if(isset($_POST['eTypeSubmit'])){
	$id = $_POST['eTypeId'];
	$name = $_POST['eTypeName'];
	$icon = $_POST['eTypeIcon'];

	if(!empty(trim($id))){
		if(!empty($name)){
			$sql = $db->query("UPDATE types SET type = ".$db->quote($name)." WHERE typeid = ".$db->quote($id));
		}
		if(!empty($icon)){
			$sql = $db->query("UPDATE types SET typeimg = ".$db->quote($icon)." WHERE typeid = ".$db->quote($id));
		}

		header("Location: ../../admin.php?error=cool");
		exit();

	}else{
		header("Location: ../../admin.php?error=emptyFields");
		exit();
	}

}else if(isset($_POST['rTypeSubmit'])){
	$id = $_POST["rTypeId"];

	if(empty($id)){
		header("Location: ../../admin.php?error=emptyFields");
		exit();
	}else{
		$dishIdSR = $db->select("SELECT dishid FROM menu WHERE dishtype =".$db->quote($id)." ");

		for($i = 0; $i<sizeof($dishIdSR); $i++){
			$remFav = $db->query("DELETE FROM favourites WHERE dishID = ".$db->quote($dishIdSR[$i]['dishid']));
			$remAllergy = $db->query("DELETE FROM hasallergies WHERE dishID = ".$db->quote($dishIdSR[$i]['dishid']));
			$remDish = $db->query("DELETE FROM menu WHERE dishtype = ".$db->quote($id));
		}

		$sql = $db->query("DELETE FROM types WHERE typeid = ".$db->quote($id));

		header("Location: ../../admin.php?error=cool");
		exit();
	}


}else if(isset($_POST['eWelMsgSubmit'])){
	$msg = $_POST['eWelMsg'];

	if(!empty($msg)){
		$sql = $db->query("UPDATE restaurant_details SET welcome_message = ".$db->quote($msg));
	}

	header("Location: ../../admin.php?error=cool");
	exit();


}else if(isset($_POST['eAddressSubmit'])){
	$add = $_POST['eAddress'];

	if(!empty($add)){
		$sql = $db->query("UPDATE restaurant_details SET address = ".$db->quote($add));
	}

	header("Location: ../../admin.php?error=cool");
	exit();

}else if(isset($_POST['eOpeningHrsSubmit'])){
	$mon = $_POST['eOpeningHrsMon'];
	$sat = $_POST['eOpeningHrsSat'];
	$sun = $_POST['eOpeningHrsSun'];

	if(!empty($mon)){
		$sql = $db->query("UPDATE opening_hours SET hours = ".$db->quote($mon)." WHERE id BETWEEN '1' AND '5'");
	}

	if(!empty($sat)){
		$sql = $db->query("UPDATE opening_hours SET hours = ".$db->quote($sat)." WHERE id = '6' ");
	}

	if(!empty($sun)){
		$sql = $db->query("UPDATE opening_hours SET hours = ".$db->quote($sun)." WHERE id = '7'");
	}

	header("Location: ../../admin.php?error=cool");
	exit();

}else if(isset($_POST['aTeamSubmit'])){
	$name = $_POST['aTeamName'];
	$role = $_POST['aTeamRole'];
	$desc = $_POST['aTeamDescription'];
	$photo = $_FILES['aTeamPhoto'];

	if(empty($name) || empty($role) || empty($desc)){
		header("Location: ../../admin.php?error=emptyFields");
		exit();
	}else if(strlen($desc) > 750){
		header("Location: ../../admin.php?error=tooManyChars");
		exit();
	}else{
		$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error']);

		if($upload === 0){
			header("Location: ../../admin.php?error=invalidFileExt");
			exit();
		}else if($upload === 1){
			header("Location: ../../admin.php?error=uploadError");
			exit();
		}else if($upload === 2){
			header("Location: ../../admin.php?error=fileTooBig");
			exit();
		}else if($upload === 3){
			header("Location: ../../admin.php?error=uploadError");
			exit();
		}else{
			$sql = $db->query("INSERT INTO team_details (name, role, description, photo) VALUES (".$db->quote($name).", ".$db->quote($role).", ".$db->quote($desc).", ".$db->quote($upload)." )");
		}

		

		header("Location: ../../admin.php?error=cool");
		exit();
	}

}else if(isset($_POST['eTeamSubmit'])){
	$id = $_POST['eTeamId'];
	$name = $_POST['eTeamName'];
	$role = $_POST['eTeamRole'];
	$desc = $_POST['eTeamDescription'];
	$photo = $_POST['eTeamPhoto'];

	if(empty($id)){
		header("Location: ../../admin.php?error=emptyFields");
		exit();
	}else{
		if(!empty($name)){
			$sql = $db->query("UPDATE team_details SET name = ".$db->quote($name)." WHERE teamid =".$db->quote($id));

		}

		if(!empty($role)){
			$sql = $db->query("UPDATE team_details SET role = ".$db->quote($role)." WHERE teamid =".$db->quote($id));

		}

		if(!empty($desc)){
			if(strlen($desc) > 750){
				$sql = $db->query("UPDATE team_details SET description = ".$db->quote($desc)." WHERE teamid =".$db->quote($id));
			}else{
				header("Location: ../../admin.php?error=tooManyChars");
				exit();
			}
		}

		if(!empty($photo)){
			$sql = $db->query("UPDATE team_details SET photo = ".$db->quote($photo)." WHERE teamid =".$db->quote($id));

		}

		header("Location: ../../admin.php?error=cool");
		exit();
	}

}else if(isset($_POST['rTeamSubmit'])){
	$id = $_POST["rTeamId"];

	if(empty($id)){
		header("Location: ../../admin.php?error=emptyFields");

	}else{
		$sql = $db->query("DELETE FROM team_details WHERE teamid = ".$db->quote($id));
		
		header("Location: ../../admin.php?error=cool");
		exit();
	}

	

}else{
	header("Location: ../../admin.php");
	exit();
}