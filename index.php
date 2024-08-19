<?php
session_start();
$inactivityDuration = 1200; // 20 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivityDuration)) {
    session_unset(); // supprime toutes les variables de session
    session_destroy();
}

// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Return an OK status code for preflight requests
    http_response_code(200);
    exit();
}

$strCtrl    = $_GET['ctrl'] ?? "index";
$strAction  = $_GET['action'] ?? "index";

include("Controller/mother_controller.php");

//Fait un test de verificaiton
if (file_exists("Controller/" . $strCtrl . "_controller.php")) {
    require("Controller/" . $strCtrl . "_controller.php");
    $strClassName   = ucfirst($strCtrl) . "_Ctrl";
    $objCtrl        = new $strClassName;
    $objCtrl->$strAction();
} else {
    header("Location:index.php?ctrl=error&action=error_404");
}
