<?php
    require_once 'bootstrap.php';
    session_start();
    echo $twig->render('404.html');