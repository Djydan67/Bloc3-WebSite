<?php
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
        $base64Signature = base64_encode($signature);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        return $base64Header . '.' . $base64Payload . '.' . $signature;
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
        return json_decode(base64_decode($arrayHeader[0]), true);
    }

    public function getPayload(string $token)
    {
        $arrayPayload = explode('.', $token);
        return json_decode(base64_decode($arrayPayload[1]), true);
    }

    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new DateTime();
        return $payload['exp'] < $now->getTimestamp();
    }

    public function validToken(string $token, string $secret): bool
    {
        return preg_match('/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/', $token) === 1
            && $this->check($token, $secret)
            && !$this->isExpired($token);
    }

    public function SessionJwt($userData)
{
    if (!empty($userData)) {
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        $payload = [
            "sub" => $userData['user_id'] ?? null,
            "name" => $userData['user_nom'] . ' ' . $userData['user_prenom'] ?? null,
            "email" => $userData['user_mail'] ?? null,
            "pseudo" => $userData['user_pseudo'] ?? null,
            "isActif" => $userData['user_isactif'] ?? null,
            "droit" => $userData['droit_id'] ?? null,
            "droit_description" => $userData['droit_description'] ?? null
        ];
        $secret = SECRET_KEY;
        $jwtToken = $this->generateJwt($header, $payload, $secret);

        error_log("Generated JWT Token: " . $jwtToken);
        return $jwtToken;
    } else {
        return false;
    }
}
}
?>
