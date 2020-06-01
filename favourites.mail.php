<?php
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    session_start();

    //Get db objects
    $db = new Db();

    if(isset($_POST['submit'])){
        if(isset($_SESSION['id'])){
            $currUser = $db->quote($_SESSION['id']);
            $result = $db->select("SELECT m.dishname as dishname, fa.dishID as dishid, m.dishdesc, m.price, m.ingredients FROM favourites fa INNER JOIN menu m ON (fa.dishID = m.dishid) INNER JOIN users u ON (fa.userid = u.id) WHERE u.id = ".$currUser."");
            
            $iter = count($result);

            //To display price in Currency Format
            for ($i = 0; $i < $iter; $i++){
                $result[$i]['price'] = '€'.number_format($result[$i]['price'], 2, ".", ",");
            }

            foreach($result as $details){
                $dname = $details['dishname'];
                $ddesc = $details['dishdesc'];
                $dpric = $details['price'];
                $dingr = $details['ingredients'];

                $currItem = "Name: " . $dname . "\nDescription: " . $ddesc . "\nIngredients: " . $dingr . "\nPrice: " . $dpric . "\n\n";     
                $message .= $currItem;  
            }            

            if (strlen(trim($message)) <= 0){
                header("Location: favourites.php?mailfail");
            } else {
                $email = $_POST['email'];
                $subject = "Favourites List (Amnaj Indian Cuisine)";
    
                $mailFrom = "amnajcuisine@gmail.com";
                $headers = "From: ".$mailFrom;
                $txt = "Dear Sir/Madam, \n\nBelow is your list of menu favourites from Amnaj Indian Cuisine.\n\n" . $message;

                if(mail($email, $subject, $txt, $headers)){
                    header("Location: favourites.php?mailsend");
                } else {
                    header("Location: favourites.php?mailfail");
                }
            }
        }
    }