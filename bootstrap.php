<?php
    //Loud our autoloader
    require_once __DIR__.'/vendor/autoload.php';

    //Specify our Twig templates location
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');

    //Instantiates our Twig
    $twig = new \Twig\Environment($loader);

    $function = new \Twig\TwigFunction("render", function($phpFile){
        require $phpFile;
    });

    $twig->addFunction($function);