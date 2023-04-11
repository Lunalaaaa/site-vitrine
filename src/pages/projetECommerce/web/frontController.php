<?php

use App\eCommerce\Controller\GenericController;

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// instantiate the loader
$loader = new App\eCommerce\Lib\Psr4AutoloaderClass();
// register the base directories for the namespace prefix
$loader->addNamespace('App\eCommerce', __DIR__ . '/../src');
// register the autoloader
$loader->register();


if (isset($_GET['controller'])) {
    $controller = ucfirst($_GET['controller']);
    $controllerClassName = '\App\eCommerce\Controller\Controller' . $controller;
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        if(class_exists($controllerClassName)){
            if(in_array($action, get_class_methods($controllerClassName))){
                $controllerName = "Controller" . ucfirst($controller);
                $controllerClassName::$action();
            }
            else{
                echo \App\eCommerce\Lib\MessageFlash::afficherMessageFlash('danger', "Cette action n'existe pas.");
                GenericController::accueil();
            }
        }
        else{
            echo \App\eCommerce\Lib\MessageFlash::afficherMessageFlash('danger', 'Ce controller n\'est pas reconnu.');
            GenericController::accueil();
        }
    }
}
else {
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        if(in_array($action, get_class_methods(GenericController::class))){
            GenericController::$action();
        }
        else{
            echo \App\eCommerce\Lib\MessageFlash::afficherMessageFlash('danger', "Cette action n'existe pas.");
            GenericController::accueil();
        }
    }
    else {
        GenericController::accueil();
    }

}






