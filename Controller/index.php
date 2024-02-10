<?php
include __DIR__ . '/../Model/bdd.php';

$uri = $_SERVER['REQUEST_URI'];
$prefix = '/bloc-3/Bloc3-WebSite';

// Retirez le préfixe du chemin
$uri = str_replace($prefix, '', $uri);

switch ($uri) {
    case '/' :
    case '/inscription' :
        require __DIR__ . '/Controller/inscription.php';
        break;
    case '/connexion':
        require __DIR__ . '/Controller/connexion.php';
        break;
    default:
        require __DIR__ . '/Controller/404.php';
        break;
}

?>
