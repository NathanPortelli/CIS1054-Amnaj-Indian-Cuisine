<?php
require_once 'bootstrap.php';
require_once 'header.php';
require_once 'dbwrapper.php';

if($_SESSION['usergroup'] == 1){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$db = new Db();

			$choice = $_POST['adminSelect'];


			switch($choice){
				case "aDish":
					header("Location: adddish.php");
					break;
				case "vDish":
					header("Location: viewdishes.php");
					break;
				case "aTeamMember":
					header("Location: addmember.php");
					break;
				case "vTeamMember":
					header("Location: viewmembers.php");
					break;
				case "eRestDets":
					header("Location: editdetails.php");
					break;
				case "aDishType":
					header("Location: addtype.php");
					break;
				case "vDishType":
					header("Location: viewtypes.php");
					break;

		}
	}else{
		echo $twig->render('admin.html', []);
	}

}else{
	header("Location: index.php");
	exit();
	//use error 403
}

require_once "footer.php";