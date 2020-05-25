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

    $resultHours = $db->select("SELECT id, Group_CONCAT(day SEPARATOR ' ') as dayrange, hours FROM opening_hours GROUP BY hours ORDER BY id");

    foreach ($resultHours as $dayoftheweek){
        $dayrange[] = $dayoftheweek['dayrange'];
        $hours[] = $dayoftheweek['hours'];
    }

    for($i = 0; $i < count($dayrange); $i++){
        if (strpos($dayrange[$i], ' ')){
            $temp = explode(' ', $dayrange[$i]);
            $dayrange[$i] = $temp[0]." - ".$temp[count($temp)-1];
        }

        $openingHours[] = array('dayrange' => $dayrange[$i], 'hourrange' => $hours[$i]);
    }

    $year = date("Y");

    echo $twig->render('footer.html', ['year' => $year, 'details' => $details, 'address' => $address, 'openingHours' => $openingHours]);