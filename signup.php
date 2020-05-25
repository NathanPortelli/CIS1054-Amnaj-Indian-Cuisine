<?php
    require_once "bootstrap.php";
    require_once 'header.php';

    $errorMessage = "";

    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyFields"){
            $errorMessage = "Please fill in all fields";
        }else if($_GET['error'] == "invalidEmail"){
            $errorMessage = "Please enter a valid email";
        }else if($_GET['error'] == "invalidName"){
            $errorMessage = "Please enter a valid name";
        }else if($_GET['error'] == "invalidSurname"){
            $errorMessage = "Please enter a valid surname";
        }else if($_GET['error'] == "passwordCheck"){
            $errorMessage = "Passwords do not match";
        }else if($_GET['error'] == "SQLError"){
            $errorMessage = "An internal database error has occured";
        }else if($_GET['error'] == "emailAlreadyUsed"){
            $errorMessage = "This email address is already in use";
        }else if($_GET['error'] == "invalidPasswordLen"){
            $errorMessage = "Password must be at least 8 characters long";
        }else if($_GET['error'] == "invalidPasswordNum"){
            $errorMessage = "Password must contain at least one numerical digit";
        }else if($_GET['error'] == "invalidPasswordUC"){
            $errorMessage = "Password must contain at least one capital letter";
        }else if($_GET['error'] == "invalidPasswordLC"){
            $errorMessage = "Password must include at least one lower case letter";
        }
    }

    echo $twig->render('signup.html', ['error' => $errorMessage]);

    require_once 'footer.php';
