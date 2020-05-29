<?php
	require_once 'bootstrap.php';
	require_once 'header.php';
	require_once 'dbwrapper.php';
	require_once 'resources/includes/validate.php';

	$db = new Db();
	$val = new Validate();

	if (isset($_SESSION['id'])){
		$validations = array();

    	if (isset($_POST['submit'])){
			$name = $_POST['new-name'];
			$surname = $_POST['new-surname'];
			$email = $_POST['new-email'];
			$passold = $_POST['passold'];
			$passwrd = $_POST['passnew'];
			$passconf = $_POST['passconf'];

			if (strlen($name) > 0){
				$vname = $val->validateString($name, 20);

				if ($name != $vname){
					$validations['name'] = $vname;
				} else {
					$name = $db->quote($name);
	
					if ($db->query("UPDATE users SET name = ".$name." WHERE users.id = ".$_SESSION['id'])){
						$_SESSION['name'] = str_replace("'", "", $name);
					} else {
						$validations['name'] = "Database failed to update";
					}
				}
			}

			if(strlen($surname) > 0){
				$vsurname = $val->validateString($surname, 20);

				if ($surname != $vsurname){
					$validations['surname'] = $vsurname;
				} else {
					$surname = $db->quote($surname);

					if($db->query("UPDATE users SET surname = ".$surname." WHERE users.id = ".$_SESSION['id'])){
						$_SESSION['surname'] = str_replace("'", "", $surname);
					} else {
						$validations['surname'] = "Database failed to update";
					}
				}
			}
			
			if (strlen($email) > 0){
				$vemail = $val->validateEmail($email);
				if ($email != $vemail){
					$validations['email'] = $vemail;
				} else {
					$email = $db->quote($_POST['new-email']);
					
					if($db->query("UPDATE users SET email = ".$email." WHERE users.id = ".$_SESSION['id'])){
						$_SESSION['email'] = str_replace("'", "", $email);
					} else {
						$validations['email'] = "Database failed to update";
					}
				}
			}

            if (!empty(trim($passold))){
                $ps = $db->select("SELECT pword FROM users WHERE id = ".$_SESSION['id']);
                if (password_verify($passold, $ps[0]['pword'])){
					$vpassword = $val->validatePasswordC($passwrd, $passconf);

					if ($passwrd != $vpassword){
						$validations['password'] = $vpassword;
					} else {
                        $hashedpassword = password_hash($passwrd, PASSWORD_DEFAULT);
                        $db->query("UPDATE users SET pword = '".$hashedpassword."' WHERE users.id = ".$_SESSION['id']);
                        header("Location: logout.php");
                        exit;
                    }
                } else {
                    $validations['password'] = "Password is incorrect";
                }
            }
		}
		
		require 'header.php';

		echo $twig->render('profile.html', ['name' => $_SESSION['name'], 'surname' => $_SESSION['surname'], 'email' => $_SESSION['email'], 'usergroup' => $_SESSION['usergroup'], 'validations' => $validations]);
    } else {
		header("Location: signin.php");
    }

	require_once 'footer.php';