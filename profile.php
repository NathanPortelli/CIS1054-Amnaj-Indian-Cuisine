<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

	if (isset($_SESSION['id'])){
		$errorMessage = "";
		if (isset($_GET['error'])){
			if ($_GET['error'] == "badPassword"){
				$errorMessage = "Password is incorrect";
			} else if ($_GET['error'] == "doNotMatch"){
				$errorMessage = "Passwords do not match";
			} else if ($_GET['error'] == "changeFailed"){
				$errorMessage = "Database failed to update";
			}
		}
		echo $twig->render('profile.html', ['name' => $_SESSION['name'], 'surname' => $_SESSION['surname'], 'email' => $_SESSION['email'], 'error' => $errorMessage]);
	} else {
		header("Location: signin.php");
	}

	require_once 'footer.php';