<?php
	/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
header ('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode(['error' => 'Méthode non autorisée']);

    exit;
}

if(isset($_SERVER['Authorization'])) {
    $token = trim($_SERVER['Authorization']);
} elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $token = trim($_SERVER['HTTP_AUTHORIZATION']);
} elseif (function_exists('apache_request_headers')) {
    $requestHeaders = apache_request_headers();

    if (isset($requestHeaders['Authorization'])) {
        $token = trim($requestHeaders['Authorization']);
    }
}

if (!isset($token) || !preg_match('/Bearer\s(|S+)/', $token, $matches)) {
    http_response_code(401);

    echo json_encode(['error' => 'Token non valide']);

    exit;
}

$token = trim(str_replace('Bearer', '', $token));
    
class auth_controller {
    
    public function verifValidationToken($token, $secret) {
        include("../Includes/config.php");
        $jwt = new Jwt();

    if (!$jwt->validToken($token, $secret)) {
        http_response_code(400);

        echo json_encode(['error' => 'Token non valide']);

        exit;
    }

    if (!$jwt->check($token, $secret)) {
        http_response_code(400);

        echo json_encode(['error' => 'Token est invalide']);

        exit;
    }

    if ($jwt->isExpired($token)) {
        http_response_code(403);

        echo json_encode(['error' => 'Le token a expiré']);

        exit;
    }
    }
}

