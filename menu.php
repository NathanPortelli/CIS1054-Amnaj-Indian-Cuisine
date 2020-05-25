<?php 
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    require_once 'header.php';

    //Get db Objects
    $db = new Db();

    //Load
    $menutypes = $db->select("SELECT typeid, type, typeimg FROM types order by typeid");

    //Render the view
    if(isset($_GET['type'])){
        $typeSelect = $db->quote($_GET['type']);
        $menudetails = $db->select("SELECT m.dishname as dishname, t.type as dishtype, ha.dishID as dishid, m.dishdesc, m.price, m.dishphoto, Group_CONCAT(al.allergy SEPARATOR ' ') as allergies FROM hasallergies ha INNER JOIN menu m ON (ha.dishID = m.dishid) INNER JOIN allergies al ON (ha.allerID = al.allergyid) INNER JOIN types t ON (m.dishtype = t.typeid) WHERE t.type=".$typeSelect." GROUP BY dishid ORDER BY dishid");
        
        $iter = count($menudetails);

        for ($i = 0; $i < $iter; $i++){
            $menudetails[$i]['price'] = '€'.number_format($menudetails[$i]['price'], 2, ".", ",");
        }

        echo $twig->render('menu.html', ['menutypes'=> $menutypes, 'menudetails' => $menudetails]);
    } else{
        echo $twig->render('menu.html', ['menutypes' => $menutypes]);
    }

    require_once 'footer.php';