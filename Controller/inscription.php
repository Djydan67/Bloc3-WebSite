<?php
include __DIR__ . '/../Model/bdd.php';

// Récupération des données
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

    // Vérification des données
    $errors = [];

    if (empty($nom) || empty($prenom) || empty($email) || empty($pseudo) || empty($password) || empty($password_confirm)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Ajoutez ici d'autres validations au besoin, comme la validation de l'email

    if (empty($errors)) {
        // Hachage du mot de passe
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Préparation et exécution de la requête SQL
        try {
            $sql = "INSERT INTO users (nom, prenom, email, pseudo, password) VALUES (:nom, :prenom, :email, :pseudo, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nom' => $nom, 
                'prenom' => $prenom,
                'email' => $email,
                'pseudo' => $pseudo,
                'password' => $password_hashed
            ]);

            header ("location: /../Bloc3-WebSite/View/connexion.html");
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
