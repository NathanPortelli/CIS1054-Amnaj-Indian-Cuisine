<?php
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    require_once 'header.php';    

    //Get db objects
    $db = new Db();

    if(isset($_SESSION['id'])){
        $errorMessage = "";

        if(isset($_GET['mailfail'])){
            $errorMessage = "Mail not sent";
        }

        $isEmpty = false;
        //User is logged in and can access items in 'My Favourites'
        //Load
        $currUser = $db->quote($_SESSION['id']);
        
        if(isset($_POST['removeItem'])){
            $favmenuID = $_POST['menuid'];
            $sql = $db->query("DELETE FROM favourites  WHERE dishID=".$favmenuID." AND userID=".$currUser."");

            if ($db->query($sql) === TRUE){  
                //Failed to delete
                //Display 404 page
                echo $twig->render('404.html');
            }
        }

        //Load result
        $result = $db->select("SELECT m.dishname as dishname, fa.dishID as dishid, m.dishdesc, m.price, m.dishphoto, m.ingredients FROM favourites fa INNER JOIN menu m ON (fa.dishID = m.dishid) INNER JOIN users u ON (fa.userid = u.id) WHERE u.id = ".$currUser."");
        if(count($result)<=0){
            $isEmpty = true;
        }

        //Display
        echo $twig->render('favourites.html', ['result' => $result, 'isEmpty' => $isEmpty, 'mailfail' => $errorMessage]);
    }else{
        //User is not logged in and therefore cannot access items in 'My Favourites'
        //Display 404 page
        echo $twig->render('404.html');
    }

    require_once 'footer.php';  