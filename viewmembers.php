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
	
	$members = $db->select("SELECT * FROM team_details");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$selectedMemberId = 0;
		
		for($i = 1; $i <= sizeof($members); $i++){
			if(isset($_POST['submit'.$i])){
				$selectedMemberId = $i;
				break;
			}
			
		}

		$selectedMember = $db->select("SELECT * FROM team_details WHERE teamid = ".$selectedMemberId);
		$member = array();
		$member['name'] = $selectedMember[0]['name'];
		$member['role'] = $selectedMember[0]['role'];
		$member['description'] = $selectedMember[0]['description'];

		echo $twig->render("editmember.html",['member' => $member]);
		
	}else{
		echo $twig->render("viewmembers.html", ['members' => $members]);
	}
}else{
	header("Location: index.php");
	exit();
}

require_once 'footer.php';
?>