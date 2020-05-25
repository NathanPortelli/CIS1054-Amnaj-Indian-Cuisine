<?php
    require_once 'bootstrap.php';
    require_once 'header.php';

	$errorMessage = "";

    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyFields"){
            $errorMessage = "Please fill in all fields";
        }else if($_GET['error'] == "invalidEmail"){
            $errorMessage = "Please enter a valid email";
        }
    }

    echo $twig->render('contactus.html', ['error' => $errorMessage]);

    require_once 'footer.php';