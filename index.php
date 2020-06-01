<?php
	require_once 'bootstrap.php';
	require_once 'dbwrapper.php';
	session_start();

	$db = new Db();

	$result = $db->select("SELECT welcome_message, ourstory, ourpromise FROM restaurant_details");
	$welcome_message = $result[0]['welcome_message'];
	$ourpromise = $result[0]['ourpromise'];
	$ourstory = $result[0]['ourstory'];

	if(!isset($_COOKIE['visited'])){
		$expiryDate = 60 * 60 * 24 + time(); //will expire in 3 months
		setcookie('visited', true, $expiryDate);
	} else {
		$welcome_message = "";
	}

	echo $twig->render('index.html', ['welcome_message' => $welcome_message, 'ourpromise' => $ourpromise, 'ourstory' => $ourstory]);