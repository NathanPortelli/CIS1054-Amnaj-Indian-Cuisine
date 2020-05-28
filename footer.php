<?php
    require_once 'dbwrapper.php';
    require_once 'bootstrap.php';

    $db = new Db();

    $result = $db->select("SELECT * FROM restaurant_details");

    if (count($result) > 0){
        $details = [
            'welcome_message' => $result[0]['welcome_message'],
            'address' => $result[0]['address'],
            'email_address' => $result[0]['email_address'],
            'telephone' => $result[0]['telephone'],
            'mobile' => $result[0]['mobile']
        ];

        $addressArray = explode(',', $details['address']);
        $address = join(", <br>", $addressArray);
    }

    $resultHours = $db->select("SELECT id, Group_CONCAT(day SEPARATOR ' ') AS dayrange, hours FROM opening_hours GROUP BY hours ORDER BY id");
    
    foreach ($resultHours as $dayoftheweek){
        /*will contain day ranges, like Monday-Tuesday, Thursday, etc
          Currently contains for example Dayrange: ([0] => Monday Tuesday Wednesday, [1] => Thursday, [2] => Friday, [3] => Saturday Sunday)*/
        $dayrange[] = $dayoftheweek['dayrange'];

        /*will contain the hours that correspond to the day ranges in the dayrange array
          Currently contains for example Hours: ([0] => 10:00 - 22:00, [1] => 11:00 - 21:00, [2] => 11:00 - 23:00, [3] => 14:00 - 24:00)*/
        $hours[] = $dayoftheweek['hours'];
    }

    //A function which returns the corresponding date number according to the day (to compare days)
    function getDateNumber ($day){
        switch ($day) {
            case 'Monday':
                return 1;
                break;
            case 'Tuesday':
                return 2;
                break;
            case 'Wednesday':
                return 3;
                break;
            case 'Thursday':
                return 4;
                break;
            case 'Friday':
                return 5;
                break;
            case 'Saturday':
                return 6;
                break;
            case 'Sunday':
                return 7;
                break;
            default:
                return 0;
                break;
        }
    }

    for($i = 0; $i < count($dayrange); $i++){
        //If the current dayrange entry contains more than 1 day of the week (for example Monday Tuesday Wednesday), it means they have the same hours
        if (strpos($dayrange[$i], ' ')){
            //The dates are put in an array called explodeddayrange Dayrange: ([0] => Monday, [1] => Tuesday, [2], Wednesday)
            $explodeddayrange = explode(' ', $dayrange[$i]);

            //The first day is inserted into $temp Temp: ([0] => Monday)
            $temp = array($explodeddayrange[0]);
            $currentdayrange = ""; //variable to contain the current (finished) dayrange (for example Monday-Wednesday)

            //Starts from 1 since the first element does not need to be compared with its previous one (element -1, which doesn't exist)
            for($j = 1; $j < count($explodeddayrange); $j++){
                /*If the difference of the date numbers of the current day and the previous day is 1, 
                  then the current date is added to the temp array (which is used to create ranges)

                  Otherwise, the previous dates that were added to temp are a range (like Monday-Wednesday) and those are added to currentdayrange
                  and the temp array is reset (and the current element is also added)
                */
                if (getDateNumber($explodeddayrange[$j]) - getDateNumber($explodeddayrange[$j-1]) != 1){
                    // ", "is added when the day is not the first one, so for example you don't get , Monday - Wednesday
                    if (strlen($currentdayrange) != 0){
                        $currentdayrange .= ", ";
                    }

                    /*If temp only contains 1 element such as "Thursday" only, there is no range and therefore only it is added
                      Otherwise, the days are added as a range with the - separator*/
                    if (count($temp) == 1){
                        $currentdayrange .= $temp[0];
                    } else {
                        $currentdayrange .= $temp[0]." - ".$temp[count($temp)-1];
                    }

                    $temp = array(); //temp array is reset
                    
                }
                //current element is added
                $temp[] = $explodeddayrange[$j]; 
            }
            
            //Adds what is left over from the temp array
            if (count($temp) > 0){
                if(strlen($currentdayrange) != 0){
                    $currentdayrange .= ", ";
                }
                
                if (count($temp) == 1){
                    $currentdayrange .= $temp[0];
                } else {
                    $currentdayrange .= $temp[0]." - ".$temp[count($temp)-1];
                }
            }

            //Inserts the new day range into the old array
            $dayrange[$i] = $currentdayrange;
        }
    }
    
    //Joins the dayrange and the hours array into 1 openingHours array to be sent to HTML
    for ($k = 0; $k < count($dayrange); $k++){
        $openingHours[] = array('dayrange' => $dayrange[$k], 'hourrange' => $hours[$k]);
    }

    $year = date("Y");

    echo $twig->render('footer.html', ['year' => $year, 'details' => $details, 'address' => $address, 'openingHours' => $openingHours]);