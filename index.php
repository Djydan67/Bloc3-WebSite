<?php
include("Controller/mother_controller.php");
$strCtrl    = $_GET['ctrl'] ?? "stuff";
$strAction  = $_GET['action'] ?? "equipements";
require("Controller/" . $strCtrl . "_controller.php");
$strClassName   = ucfirst($strCtrl) . "_Ctrl";
$objCtrl        = new $strClassName;
$objCtrl->$strAction();
