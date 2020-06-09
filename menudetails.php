<?php
    require_once "bootstrap.php";
    require_once "dbwrapper.php";
    session_start();

    $db = new Db();

    if(isset($_GET['dish'])){
        $isAdded = true;
        
        if(isset($_SESSION['id'])){
            $favmenuID = $db->quote($_GET['dish']);
            $currUser = $_SESSION['id'];

            $sel = "SELECT dishID FROM favourites WHERE dishID=".$favmenuID." AND userID=".$currUser;
            $query = $db->select($sel);

            //If it does already exist within the user's Favourites List
            if (!(count($query) > 0)){     
                $isAdded = false;
            }
        }

        //quotes dish id to prevent SQL injection
        $dishIDquoted = $db->quote($_GET['dish']);

        //gets result of the select query
        $result = $db->select("SELECT dishid AS id, dishname, dishdesc, t.type AS dishtype, menu.dishtype AS dishtypeid, ingredients, price, dishphoto, serving FROM menu INNER JOIN types t ON (menu.dishtype = t.typeid) WHERE dishid = ".$dishIDquoted);
        $resultallergy = $db->select("SELECT al.name, al.allergyicon FROM allergies al INNER JOIN hasallergies ha ON (ha.allerID = al.allergyid) WHERE dishid = ".$dishIDquoted);

        //gets the largest id of the menu
        $largestIDresult = $db->select("SELECT max(dishid) as maxid FROM menu");

        //converts the 2D associative array to a single string
        $largestID = $largestIDresult[0]['maxid'];
        
        //check to see if SQL query returns a result
        if(count($result) > 0){
            //removes quotes around the dishID
            $dishID = str_replace("'", "", $dishIDquoted);

            //Price is formatted below
            $result[0]['price'] = '€'.number_format($result[0]['price'], 2, ".", ",");
            
            echo $twig->render('menudetails.html', ['result' => $result, 'resultallergy' => $resultallergy, 'isAdded' => $isAdded]);
        } else {
            header("Location: menu.php?error=invalidID");
            exit;
        }
    } else {
        header("Location: menu.php?error=invalidID");
        exit;
    }

    if(isset($_POST['favBtn'])){
        if(isset($_SESSION['id']) && isset($_POST['menuid'])){
            $favmenuID = $_POST['menuid'];
            $currUser = $_SESSION['id'];

            $sel = "SELECT dishID FROM favourites WHERE dishID=".$favmenuID." AND userID=".$currUser;
            $query = $db->query($sel);

            //If it does not already exist within the user's Favourites List
            if (!$query->num_rows > 0) {        
                $sql = $db->query("INSERT INTO favourites(userID, dishID) VALUES ($currUser, $favmenuID)");
            }else{
                echo $twig->render('404.html');
            }
            
            header("Location: menudetails.php?dish=$favmenuID");
        }else{
            //User is not logged in and therefore cannot access items in 'My Favourites'
            echo $twig->render('404.html');
        }
    }

    