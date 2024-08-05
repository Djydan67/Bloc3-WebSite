<?php
	/**
 * Entité des utilisateurs
 * @author Théo Bance
 * ! Pour la SECRET_KEY, elle est définie dans le fichier config.php
 * ! Contactez moi pour l'obtenir
 */
include("Includes/config.php");
class Jwt
{
    public function generateJwt(array $header, array $payload, string $secret, int $validity = 3600): string 
    {
        if ($validity > 0) {
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['exp'] = $expiration;
            $payload['iat'] = $now->getTimestamp();
        }

        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);


        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);
        $base64Signature =  base64_encode($signature);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }

    public function check(string $token, string $secret): bool 
    {
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $verifToken = $this->generateJwt($header, $payload, $secret, 0);

        return $token === $verifToken;
    }

    public function getHeader(string $token)
    {
        $arrayHeader = explode('.', $token);

        $header = json_decode(base64_decode($arrayHeader[0]), true);

        return $header;
    }

    public function getPayload(string $token)
    {
        $arrayPayload = explode('.', $token);

        $payload = json_decode(base64_decode($arrayPayload[1]), true);

        return $payload;
    }

    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTime();
        $now = $now->getTimestamp();

        return $payload['exp'] < $now;
    }

    public function validToken(string $token, string $secret): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/', $token
        ) === 1
        && $this->check($token, $secret) && !$this->isExpired($token);
    }

    public function SessionJwt() {
        include("Model/user_model.php");
        $objUserModel = new user_model();
        $arrErrors = array();
        $userData = $objUserModel->getByMail($arg);

        if (!empty($userData)) {
            $header = [
                "alg" => "HS256",
                "typ" => "JWT"
            ];

            $payload = [
                "sub" => $userData['id'],
                "name" => $userData['name'],
                "email" => $userData['email']
            ];
            $secret = SECRET_KEY;
            $jwtToken = $this->generateJwt($header, $payload, $secret);
            echo $jwtToken;
            return $jwtToken;
        } else {
            $arrErrors[] = "User data not found";
            return false;
        }
    }
}
