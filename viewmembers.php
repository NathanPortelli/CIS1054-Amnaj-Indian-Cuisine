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
		$isEdit = false;
		$isDelete = false;
		$i = 1;

		while($selectedMemberId === 0){
			if(isset($_POST['submit'.$i])){
				$selectedMemberId = $i;
				$isEdit = true;
				break;
			}else if(isset($_POST['delete'.$i])){
				$selectedMemberId = $i;
				$isDelete = true;
				break;
			}
			$i++;

		}
		
		$selectedMember = $db->select("SELECT * FROM team_details WHERE teamid = ".$selectedMemberId);
		$member = array();
		$member['id'] = $selectedMember[0]['teamid'];
		$member['name'] = $selectedMember[0]['name'];
		$member['role'] = $selectedMember[0]['role'];
		$member['description'] = $selectedMember[0]['description'];

		if($isEdit === true){	
			echo $twig->render("editmember.html",['member' => $member]);
		}else if($isDelete === true){
			$sql = $db->query("DELETE FROM team_details WHERE teamid = ".$db->quote($member['id']));
			header("Location: admin.php?success=true");
			exit();
		}
	}else{
		echo $twig->render("viewmembers.html", ['members' => $members]);
	}
}else{
	header("Location: index.php");
	exit();
}

require_once 'footer.php';
