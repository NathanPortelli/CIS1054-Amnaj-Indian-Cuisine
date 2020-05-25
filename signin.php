<?php
    require_once 'header.php';

    $errorMessage = "";

    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyFields"){
            $errorMessage = "Please fill in all fields";

        }else if($_GET['error'] == "invalidEmail"){
            $errorMessage = "Please enter a valid email";
    
        }else if($_GET['error'] == "SQLError"){
            $errorMessage = "An internal database error has occured";
        
        }else if($_GET['error'] == "incorrectPassword"){
            $errorMessage = "The password used is incorrect";

        }else if($_GET['error'] == "noUser"){
            $errorMessage = "User does not exist";
        }
    }

    echo $twig->render('signin.html', ['error' => $errorMessage]);

    require_once 'footer.php';