<?php 
include("_partial/header.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <link rel="stylesheet" href="../Assets/Style/Bootstrap/bootstrap.css"/>
    <title>Profil Utilisateur</title>
</head>
<body class="fond">
    <header id="entete">
        <h1 id="title">Profil Utilisateur</h1>
    </header>
    <main class="fond">
        <div class="container">
            <h2>Informations du Profil</h2>
            <ul>
                <li>Pseudo: <?php echo htmlspecialchars($arrUser['user_pseudo']); ?></li>
                <li>Nom: <?php echo htmlspecialchars($arrUser['user_nom']); ?></li>
                <li>Prénom: <?php echo htmlspecialchars($arrUser['user_prenom']); ?></li>
                <li>Email: <?php echo htmlspecialchars($arrUser['user_mail']); ?></li>
                <li>Date de Naissance: <?php echo htmlspecialchars($arrUser['user_dob']); ?></li>
                <li>Date de Création du Compte: <?php echo htmlspecialchars($arrUser['user_creation_date']); ?></li>
                <li>
                    Mot de Passe: <span id="password">********</span>
                    <button onclick="togglePassword()">Afficher</button>
                </li>
            </ul>

            <?php if ($userLevel == 2 || $userLevel == 3) : ?>
                <h3>Panel Modération</h3>
                <div>
                    <textarea placeholder="Raison du ban"></textarea>
                    <?php if ($userLevel == 2) : ?>
                        <button onclick="banUser('7')">Ban de 7 jours</button>
                    <?php endif; ?>
                    <?php if ($userLevel == 3) : ?>
                        <button onclick="banUser('permanent')">Ban Permanent</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script>
        function togglePassword() {
            var passwordElement = document.getElementById('password');
            if (passwordElement.textContent === '********') {
                passwordElement.textContent = '<?php echo addslashes($arrUser['user_mdp']); ?>';
            } else {
                passwordElement.textContent = '********';
            }
        }

        function banUser(duration) {
            // Code pour bannir l'utilisateur avec la durée donnée (7 jours ou permanent)
            console.log(`Banning user for ${duration}`);
        }
    </script>
    <?php 
    //include("_partial/footer.php");
    ?>
</body>
</html>
