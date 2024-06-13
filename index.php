<?php

    $strCtrl    = $_GET['ctrl']??"stuff";
    $strAction  = $_GET['action']??"equipements";

    require("Controller/mother_controller.php");

    /* TODO : Compléter les tests de vérification */
    if (file_exists("Controller/".$strCtrl."_controller.php")){
        require("Controller/".$strCtrl."_controller.php");
        $strClassName   = ucfirst($strCtrl)."_Ctrl";
        $objCtrl        = new $strClassName;
        $objCtrl->$strAction();
    }else{
        header("Location:index.php?ctrl=error&action=error_404");
    }

    // debug

    if (class_exists($controllerClass)) {
        var_dump("Contrôleur trouvé: $controllerClass"); // Débogage
        $controller = new $controllerClass();
    
        // Vérification si l'action existe dans le contrôleur
        if (method_exists($controller, $action)) {
            var_dump("Action trouvée: $action"); // Débogage
            $controller->$action();
        } else {
            var_dump("L'action '$action' n'existe pas.");
        }
    } else {
        var_dump("Le contrôleur '$controllerClass' n'existe pas.");
    }