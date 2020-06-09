<?php
    require_once 'bootstrap.php';
    require_once 'resources/includes/validate.php';
    session_start();

    $validations = array();
    $formvalues = array();
    $val = new Validate();

    if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['email']) && isset($_POST['message'])){
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];
    
        if (empty($name)){
            $validations['name'] = "Name should not be empty";
        }

        $vemail = $val->validateEmail($email);
        if ($email != $vemail){
            $validations['email'] = $vemail;
        }

        if (empty($subject)){
            $validations['subject'] = "Subject should not be empty";
        }

        if (empty($message)){
            $validations['message'] = "Message should not be empty";
        }
        
        if (empty($validations)){
            $mailTo = "amnajcuisine@gmail.com";
            $headers = "From: ".$email;
            $txt = "You have received an email from ".$name." (".$email.").\n\n".$message;

            if(mail($mailTo, $subject, $txt, $headers)){
                header("Location: contactus.php?mailsend");
                exit();
            } else {
                header("Location: contactus.php?mailfail");
                exit();
            }
        }

        $formvalues['name'] = $name;
        $formvalues['email'] = $email;
        $formvalues['subject'] = $subject;
        $formvalues['message'] = $message;
    }

    echo $twig->render('contactus.html', ['validations' => $validations, 'formvalues' => $formvalues]);