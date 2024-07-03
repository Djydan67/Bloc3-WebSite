<?php

    session_start();

    $strCtrl    = $_GET['ctrl'] ?? "index";
    $strAction  = $_GET['action'] ?? "index";

    include("Controller/mother_controller.php");

    //Fait un test de verificaiton
    if(file_exists("Controller/".$strCtrl."_controller.php")){
        require("Controller/" . $strCtrl . "_controller.php");
        $strClassName   = ucfirst($strCtrl) . "_Ctrl";
        $objCtrl        = new $strClassName;
        $objCtrl->$strAction();
    }else{
        header("Location:index.php?ctrl=error&action=error_404");
    }
