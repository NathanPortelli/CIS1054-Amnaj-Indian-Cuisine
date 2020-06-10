<?php
    require "bootstrap.php";
    
    ini_set("display_errors", FALSE);

    if (isset($_SESSION['id'])){
        $firstButton = strtoupper($_SESSION['name']);
        $firstLink = "profile.php";
        $secondButton = "LOGOUT";
        $secondLink = "logout.php";
    } else {
        $firstButton = "SIGN UP";
        $firstLink = "signup.php";
        $secondButton = "LOGIN";
        $secondLink = "signin.php";
    }

    echo $twig->render('header.html', ['firstButton' => $firstButton, 'firstLink' => $firstLink, 'secondButton' => $secondButton, 'secondLink' => $secondLink]);