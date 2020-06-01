<?php
require_once 'dbwrapper.php';
require_once 'bootstrap.php';
require_once 'resources/includes/handleimages.php';
require_once 'resources/includes/validate.php';
session_start();

if($_SESSION['usergroup'] == 1){
	$db = new Db();
	$val = new Validate();
	$himg = new HandleImages();
	
	$details = $db->select("SELECT * FROM restaurant_details");
	$openingHours = $db->select("SELECT * FROM opening_hours");

	$dets = array();
	$dets['welMsg'] = $details[0]['welcome_message'];
	$dets['address'] = $details[0]['address'];
	$dets['email'] = $details[0]['email_address'];
	$dets['telNum'] = $details[0]['telephone'];
	$dets['mobNum'] = $details[0]['mobile'];
	$dets['ourStory'] = $details[0]['ourstory'];
	$dets['ourPromise'] = $details[0]['ourpromise'];
	$dets['id'] = $details[0]['id'];

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$welMsg = $_POST["eWelMsg"];
		$address = $_POST["eAddress"];
		$telNum = $_POST["eTelNum"];
		$mobNum = $_POST["eMobNum"];
		$email = $_POST["eEmail"];
		$ourStory = $_POST["eStory"];
		$ourPromise = $_POST["ePromise"];
		$id = $_POST['eResId'];
		$validations = array();
		$formvalues = array();

		$days = array();
		for($i = 1; $i<=7; $i++){
			$days[$i] = $_POST['e'.$i];

			$vday = $val->validateIntE($days[$i], 15);
			if($vday != $days[$i]){
				$validations['openHours'] = $vday;
			}
		}

		$vid = $val->validateInt($id, 3);
		$idCheck = $db->select("SELECT id FROM restaurant_details WHERE id = ".$db->quote($id));
		
		if($id != $vid){
			$validations['id'] = $vid;
		}else if($idCheck === false){
			$validations['id'] = "Please enter an existing id";
		}

		$vwelMsg = $val->validateArea($welMsg, 200);
		
		if($welMsg != $vwelMsg){
			$validations['welMsg'] = $vwelMsg;
		}

		$vaddress = $val->validateArea($address, 200);
		
		if($address != $vaddress){
			$validations['address'] = $vaddress;
		}

		$vemail = $val->validateEmail($email);
		
		if($email != $vemail){
			$validations['email'] = $vemail;
		}
		
		$vtelNum = $val->validateIntE($telNum, 12);
		
		if($telNum != $vtelNum){
			$validations['telNum'] = $vtelNum;
		}

		$vmobNum = $val->validateIntE($mobNum, 12);
		
		if($mobNum != $vmobNum){
			$validations['mobNum'] = $vmobNum;
		}

		$vourStory = $val->validateArea($ourStory, 1000);
		
		if($ourStory != $vourStory){
			$validations['ourStory'] = $vourStory;
		}

		$vourPromise = $val->validateArea($ourPromise, 1000);
		
		if($ourPromise != $vourPromise){
			$validations['ourPromise'] = $vourPromise;
		}
		
		if(!empty($validations)){
			$formvalues['welMsg'] = $welMsg;
			$formvalues['address'] = $address;
			$formvalues['ourStory'] = $ourStory;
			$formvalues['ourPromise'] = $ourPromise;
			$formvalues['email'] = $email;
			$formvalues['telNum'] = $telNum;
			$formvalues['mobNum'] = $mobNum;
			$formvalues['id'] = $id;

			echo $twig->render("editdetails.html", ['validations' => $validations, 'formvalues' => $formvalues, 'openingHours' => $openingHours]);
		}else{
			$sql = $db->query("UPDATE restaurant_details SET welcome_message =".$db->quote($welMsg).", address=".$db->quote($address).", email_address=".$db->quote($email).", telephone =".$db->quote($telNum).", mobile =".$db->quote($mobNum).", ourstory =".$db->quote($ourStory).", ourpromise =".$db->quote($ourPromise)." WHERE id=".$db->quote($id));

			for($i = 1; $i <= 7; $i++){
				$updateOpenHours = $db->query("UPDATE opening_hours SET hours=".$db->quote($days[$i])." WHERE id=".$i);
			}

			header("Location: admin.php?success=true");
			exit();
		}

	}else{
		echo $twig->render("editdetails.html", ['dets' => $dets, 'openingHours' => $openingHours]);
	}
}else{
	header("Location: index.php");
	exit();
}

require_once 'footer.php';
?>
