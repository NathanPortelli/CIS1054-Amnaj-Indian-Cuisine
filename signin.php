<?php
    $errorMessage = "";
    require_once "bootstrap.php";
    session_start();

    //making sure access to this page was granted from the form
    if(isset($_POST['login'])){
        require_once 'dbwrapper.php';
        require_once 'resources/includes/validate.php';
        $db = new Db();
        $val = new Validate();
    
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = $db->select("SELECT * FROM users WHERE email=".$db->quote($email));
    
        if(count($sql) <= 0){
            $errorMessage = "Email or password is incorrect";
        }else{
            //checking to see if password matches hashed version
            $passCheck = password_verify($password, $sql[0]['pword']);
            
            if(!$passCheck){
                $errorMessage = "Email or password is incorrect";
            } else {
                $_SESSION['id'] = $sql[0]['id'];
                $_SESSION['email'] = $sql[0]['email'];
                $_SESSION['name'] = $sql[0]['name'];
                $_SESSION['surname'] = $sql[0]['surname'];
                $_SESSION['usergroup'] = $sql[0]['usergroup'];

                header("Location: index.php?login=success");
                exit();
            }
        }
    }
    
    echo $twig->render('signin.html', ['error' => $errorMessage]);