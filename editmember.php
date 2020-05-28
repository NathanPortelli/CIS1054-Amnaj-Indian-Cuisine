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
		$name = $_POST["eTeamName"];
		$role = $_POST["eTeamRole"];
		$desc = $_POST["eTeamDescription"];
		$photo = $_FILES["eTeamPhoto"];
		$photoCheck = true;
		$validations = array();
		$formvalues = array();

		$vname = $val->validateStringR($name, 100);
		// echo "name: ".$name;
		if($name != $vname){
			$validations['name'] = $vname;
		}

		$vdesc = $val->validateArea($desc, 200);
		// echo "desc: ".$desc;
		if($desc != $vdesc){
			$validations['desc'] = $vdesc;
		}

		$vrole = $val->validateString($role, 100);
		// echo "name: ".$name;
		if($role != $vrole){
			$validations['role'] = $vrole;
		}

		$memberId = $db->select("SELECT teamid FROM team_details WHERE name=".$db->quote($name)." AND role=".$db->quote($role)." AND description=".$db->quote($desc)." AND photo=".$db->quote($upload));
		
		if($photo['size'] !== 0){
			$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error']);

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
			$photoCheck = false;
		}

		

		if(!empty($validations)){
			$formvalues['name'] = $name;
			$formvalues['desc'] = $desc;
			$formvalues['role'] = $role;
			$formvalues['photo'] = $photo;


			echo $twig->render("editdish.html", ['validations' => $validations, 'formvalues' => $formvalues]);
		}else{
			if($photoCheck === true){
				$sql = $db->query("UPDATE team_details SET name =".$db->quote($name).", role=".$db->quote($role).", description=".$db->quote($desc).", photo=".$db->quote($upload)." WHERE teamid=".$memberId[0]['teamid']);
			
			}else{
				$sql = $db->query("UPDATE team_details SET name =".$db->quote($name).", role=".$db->quote($role).", description=".$db->quote($desc)." WHERE teamid=".$memberId[0]['teamid']);
			}
			
			header("Location: editmember.html?success=true");
			exit();
		}

	}else{
		echo $twig->render("editmember.html");
	}
}else{
	header("Location: index.php");
	exit();
}

require_once 'footer.php';
?>