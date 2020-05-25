<?php

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mailTo = "amnajcuisine@gmail.com";
    $headers = "From: ".$email;
    $txt = "You have received an email from ".$name." (".$email.").\n\n".$message;

    if(empty($name) || empty($email) || empty($subject) || empty($message)){
        header("Location: ./contactus.php?error=emptyFields");
        exit();
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ./contactus.php?error=invalidEmail");
        exit();
    }else{
        if(mail($mailTo, $subject, $txt, $headers)){
            header("Location: contactus.php?mailsend");

        } else {
            header("Location: contactus.php?mailfail");
        }
    }
}