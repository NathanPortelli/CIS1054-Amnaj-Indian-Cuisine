<?php
    require_once '../../bootstrap.php';
    require_once '../../dbwrapper.php';
    require_once '../../header.php';

    $db = new Db();

    if(isset($_POST['favBtn']))
    {
        $conn = mysqli_connect("localhost", "root", "", "amnajdb");
        if(isset($_SESSION['id']))
        {
            $favmenuID = $_POST['menuid'];
            $currUser = $db->quote($_SESSION['id']);

            $sel = "SELECT dishID FROM favourites WHERE dishID=".$favmenuID." AND userID=".$currUser."";
            $query = $conn->query($sel);

            if ($query->num_rows > 0) 
            {
                //header("Location: ../../menudetails.php?dish=$favmenuID");
                $message = "This item has already been added to your Favourites.";
                echo "<script type='text/javascript'>alert('$message');window.location.href='../../menudetails.php?dish=$favmenuID';</script>";
            } 
            else 
            {           
                $sql = "INSERT INTO favourites(userID, dishID) VALUES ($currUser, $favmenuID)";

                if(!mysqli_query($conn, $sql))
                {
                    $message = "Failed to put item in your Favourites. Please refresh and try again.";
                }
                else
                {
                    $message = "Menu item successfully added to your Favourites.";   
                }
            }
            mysqli_close($conn);
            header("Refresh:0; url=../../menudetails.php?dish=$favmenuID");
            echo "<script type='text/javascript'>alert('$message');</script>";
            exit();
        }    
        else
        {
            //User is not logged in and therefore cannot access items in 'My Favourites'
            $message = "Please log in to add items to your favourites.";
            echo "<script type='text/javascript'>alert('$message');window.location.href='../../menudetails.php?dish=$favmenuID';</script>";
        }
    }