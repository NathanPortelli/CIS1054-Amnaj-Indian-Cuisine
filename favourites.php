<?php
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    require_once 'header.php';    

    $db = new Db();

    $sql = "SELECT dishname, t.type as dishtype, dishdesc, price, dishphoto FROM menu INNER JOIN types t ON (menu.dishtype = t.typeid)";
    $result = $db->select($sql);

    echo $twig->render('favourites.html', ['result' => $result]);

    require_once 'footer.php';