<?php
require_once 'bootstrap.php';
require_once 'header.php';
require_once 'dbwrapper.php';

if($_SESSION['usergroup'] == 1){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$db = new Db();

			$choice = $_POST['adminSelect'];


			switch($choice){
				case "aTeamMember":
					header("Location: addteammember.php");
					break;
				case "eTeamMember":
					header("Location: editteammember.php");
					break;
				case "eRestDets":
					header("Location: editdetails.php");
					break;
				case "aDishType":
					header("Location: adddishtype.php");
					break;
				case "eDishType":
					header("Location: editdishtype.php");
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