<?php
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $subject = "Favourites list (Amnaj Indian Cuisine)";
        $message = "LIST OF DISHES";

        $mailFrom = "amnajcuisine@gmail.com";
        $headers = "From: ".$mailFrom;
        $txt = "Dear Sir/Madam, \n\nIn this email you will find contained the list of favourites from Amnaj Indian Cuisine.\n\n".$message;

        if(mail($email, $subject, $txt, $headers)){
            header("Location: favourites.php?mailsend");
        } else {
            header("Location: favourites.php?mailfail");
        }
    }