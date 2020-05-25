<?php
require_once 'bootstrap.php';
require_once 'header.php';

if($_SESSION['usergroup'] != 1){
	header("Location: profile.php");
	exit();
	//use error 403
}

echo $twig->render('admin.html');

require_once "footer.php";