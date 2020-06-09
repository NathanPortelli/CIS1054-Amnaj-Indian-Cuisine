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
			
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eTypeName']) && isset($_POST['eTeamRole']) && isset($_POST['eTeamDescription']) && isset($_FILES['eTeamPhoto']) && isset($_POST['eTeamId'])){
				$name = $_POST["eTeamName"];
				$role = $_POST["eTeamRole"];
				$desc = $_POST["eTeamDescription"];
				$photo = $_FILES["eTeamPhoto"];
				$id = $_POST['eTeamId'];
				$photoCheck = true;
				$validations = array();
				$formvalues = array();

				$vid = $val->validateInt($id, 3);
				$idCheck = $db->select("SELECT teamid FROM team_details WHERE teamid = ".$db->quote($id));
				
				if($id != $vid){
					$validations['id'] = $vid;
				}else if($idCheck === false){
					$validations['id'] = "Please enter an existing id";
				}

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
					$upload = $himg->upload($photo['name'], $photo['tmp_name'], $photo['size'], $photo['error'], "staffimages");

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
					$formvalues['id'] = $id;

					echo $twig->render("editmember.html", ['validations' => $validations, 'formvalues' => $formvalues]);
				}else{
					if($photoCheck === true){
						$sql = $db->query("UPDATE team_details SET name =".$db->quote($name).", role=".$db->quote($role).", description=".$db->quote($desc).", photo=".$db->quote($upload)." WHERE teamid=".$db->quote($id));
					}else{
						$sql = $db->query("UPDATE team_details SET name =".$db->quote($name).", role=".$db->quote($role).", description=".$db->quote($desc)." WHERE teamid=".$db->quote($id));
					}
					
					header("Location: viewmembers.php?success=true");
					exit();
				}
			}else{
				echo $twig->render("editmember.html");
			}
		}else{
			header("Location: index.php", true, 403);
			exit();
		}
	} else {
		header("Location: signin.php");
		exit();
	}