<?php
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    require_once 'header.php';

    $db = new Db();

    $sql = "SELECT name, role, description, photo FROM team_details";
    $result = $db->select($sql);
    
    echo $twig->render('staff.html', ['result' => $result]);

    require_once 'footer.php';