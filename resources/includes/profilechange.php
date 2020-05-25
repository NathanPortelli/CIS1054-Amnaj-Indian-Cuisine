<?php
    session_start();
    require_once '../../dbwrapper.php';

    $db = new Db();

    if (isset($_POST['submit'])){
        if (isset($_SESSION['id'])){
            if (!empty(trim($_POST['new-name']))){
                $name = $db->quote($_POST['new-name']);
                if ($db->query("UPDATE users SET name = ".$name." WHERE users.id = ".$_SESSION['id'])){
                    $_SESSION['name'] = str_replace("'", "", $name);
                } else {
                    header("Location: ../../profile.php?error=changeFailed");
                }
            }

            if (!empty(trim($_POST['new-surname']))){
                $surname = $db->quote($_POST['new-surname']);
                if($db->query("UPDATE users SET surname = ".$surname." WHERE users.id = ".$_SESSION['id'])){
                    $_SESSION['surname'] = str_replace("'", "", $surname);
                } else {
                    header("Location: ../../profile.php?error=changeFailed");
                }
            }
            
            if (!empty(trim($_POST['new-email']))){
                if (!filter_var($_POST['new-email'], FILTER_VALIDATE_EMAIL)){
                    header("Location: ../../profile.php?error=invalidEmail");
                } else {
                    $email = $db->quote($_POST['new-email']);
                    echo "<script type='text/javascript'>alert('Hello');</script>";
                    if($db->query("UPDATE users SET email = ".$email." WHERE users.id = ".$_SESSION['id'])){
                        $_SESSION['email'] = str_replace("'", "", $email);
                    } else {
                        header("Location: ../../profile.php?error=changeFailed");
                    }
                }
            }

            if (!empty(trim($_POST['passold'])) && !empty(trim($_POST['passnew'])) && !empty(trim($_POST['passconf']))){
                $ps = $db->select("SELECT pword FROM users WHERE id = ".$_SESSION['id']);
                if (password_verify($_POST['passold'], $ps[0]['pword'])){
                    if (strcmp($_POST['passnew'], $_POST['passconf']) == 0){
                        $passwrd = $_POST['passnew'];
                        $hashedpassword = password_hash($passwrd, PASSWORD_DEFAULT);
                        $db->query("UPDATE users SET pword = '".$hashedpassword."' WHERE users.id = ".$_SESSION['id']);
                        header("Location: logout.inc.php");
                        exit;
                    } else {
                        header("Location: ../../profile.php?error=doNotMatch");
                        exit;
                    }
                } else {
                    header("Location: ../../profile.php?error=badPassword");
                    exit;
                }
            }

            header("Location: ../../profile.php");
        } else {   
            header("Location: ../../signin.php");
        }
    } else {
        header("Location: ../../index.php");
    }