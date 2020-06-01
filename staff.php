<?php
    require_once 'bootstrap.php';
    require_once 'dbwrapper.php';
    session_start();

    $db = new Db();

    $sql = "SELECT name, role, description, photo FROM team_details";
    $result = $db->select($sql);
    
    echo $twig->render('staff.html', ['result' => $result]);