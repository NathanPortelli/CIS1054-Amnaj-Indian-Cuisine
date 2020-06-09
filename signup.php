<?php
    require_once "bootstrap.php";
    session_start();

    $validations = array();
    $formvalues = array();

    if(isset($_POST['signup']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword'])){
        require_once 'dbwrapper.php';
        require_once 'resources/includes/validate.php';
        $db = new Db();
        $val = new Validate();

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['confirmpassword'];
    
        $vname = $val->validateString($name, 20);
        if ($name != $vname){
            $validations['name'] = $vname;
        }

        $vsurname = $val->validateString($surname, 20);
        if ($surname != $vsurname){
            $validations['surname'] = $vsurname;
        }

        $vemail = $val->validateEmail($email);
        if ($email != $vemail){
            $validations['email'] = $vemail;
        }

        $vpassword = $val->validatePasswordC($password, $cpassword);
        if ($password != $vpassword){
            $validations['password'] = $vpassword;
        }

        if (empty($validations)){
            $sql = $db->select("SELECT email FROM users WHERE email=".$db->quote($email));
    
            if(count($sql) <= 0){
                $hashedpword = password_hash($password, PASSWORD_DEFAULT);	
    
                $sqlAdd = $db->query("INSERT INTO users (email, pword, name, surname) VALUES (".$db->quote($email).", ".$db->quote($hashedpword).", ".$db->quote($name).", ".$db->quote($surname).")");
                    
                header("Location: signin.php");
                exit();
            }else{	
                $validations['email'] = "Email already in use";
            }
        }

        $formvalues['name'] = $name;
        $formvalues['surname'] = $surname;
        $formvalues['email'] = $email;   
    }

    echo $twig->render('signup.html', ['validations' => $validations, 'formvalues' => $formvalues]);
