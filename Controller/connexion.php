<?php
include __DIR__ . '/../Model/bdd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les variables sont définies
    $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Vérification des identifiants
    try {
        $sql = "SELECT * FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // La connexion est réussie, vous pouvez rediriger l'utilisateur ou effectuer d'autres actions
            echo "Connexion réussie !";
        } else {
            echo "Identifiants incorrects.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
}
?>
