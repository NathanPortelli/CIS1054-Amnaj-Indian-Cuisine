<?php
    session_start();
    
    require_once "bootstrap.php";
    
    if (isset($_SESSION['id'])){
        $firstButton = strtoupper($_SESSION['name']);
        if ($_SESSION['usergroup'] == 1){
            $firstLink = "admin.php";
        } else {
            $firstLink = "profile.php";
        }
        $secondButton = "LOGOUT";
        $secondLink = "resources/includes/logout.inc.php";
    } else {
        $firstButton = "SIGN UP";
        $firstLink = "signup.php";
        $secondButton = "LOGIN";
        $secondLink = "signin.php";
    }
    
    echo $twig->render('header.html', ['firstButton' => $firstButton, 'firstLink' => $firstLink, 'secondButton' => $secondButton, 'secondLink' => $secondLink]);