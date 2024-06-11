<?php
include("Controller/mother_controller.php");
$strCtrl    = $_GET['ctrl'] ?? "article";
$strAction  = $_GET['action'] ?? "index";
// require("Controller/".$strCtrl."_controller.php");
$strClassName   = ucfirst($strCtrl) . "_Ctrl";
$objCtrl        = new $strClassName;
$objCtrl->$strAction();
