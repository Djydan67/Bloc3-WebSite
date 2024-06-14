<?php 
//include("_partial/header.php");
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
            <?php
            // Debugging variables
            include("../Entities/user_entity.php");
            include("../Model/user_model.php");
            $UserModel = new user_model();
            $arrUser = $UserModel->getFirstUser();
            $userLevel = $arrUser['user_droit'] ?? 1; // Assume user_droit is in $arrUser
            var_dump($arrUser);

            // Retrieve list of users with droit = 1
            $userList = $UserModel->getUsersByDroit(1);
            ?>
            <h2>Informations du Profil</h2>
            <ul>
                <li>Pseudo: <?php echo htmlspecialchars($arrUser['user_pseudo'] ?? 'N/A'); ?></li>
                <li>Nom: <?php echo htmlspecialchars($arrUser['user_nom'] ?? 'N/A'); ?></li>
                <li>Prénom: <?php echo htmlspecialchars($arrUser['user_prenom'] ?? 'N/A'); ?></li>
                <li>Email: <?php echo htmlspecialchars($arrUser['user_mail'] ?? 'N/A'); ?></li>
                <li>Date de Naissance: <?php echo htmlspecialchars($arrUser['user_datenaissance'] ?? 'N/A'); ?></li>
                <li>Date de Création du Compte: <?php echo htmlspecialchars($arrUser['user_datecreation'] ?? 'N/A'); ?></li>
                <li>
                    Mot de Passe: <span id="password">********</span>
                    <button onclick="togglePassword()">Afficher</button>
                </li>
            </ul>

            <?php if ($arrUser['droit_id'] == 2 || $arrUser['droit_id'] == 3) : ?>
                <h3>Panel Modération</h3>
                <div>
                    <label for="userSelect">Sélectionnez un utilisateur à bannir :</label>
                    <select id="userSelect">
                        <?php foreach ($userList as $user): ?>
                            <option value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                <?php echo htmlspecialchars($user['user_pseudo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <textarea placeholder="Raison du ban"></textarea>
                    <button onclick="banUser('7')">Bannir pour 7 jours</button>
                    <?php if ($userLevel == 3) : ?>
                        <button onclick="banUser('permanent')">Bannir définitivement</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script>
        function togglePassword() {
            var passwordElement = document.getElementById('password');
            if (passwordElement.textContent === '********') {
                passwordElement.textContent = '<?php echo addslashes($arrUser['user_mdp'] ?? ''); ?>';
            } else {
                passwordElement.textContent = '********';
            }
        }

        function banUser(duration) {
            var userId = document.getElementById('userSelect').value;
            // Code pour bannir l'utilisateur avec la durée donnée (7 jours ou permanent)
            console.log(`Banning user with ID ${userId} for ${duration}`);
        }
    </script>
    <?php 
    include("_partial/footer.php");
    ?>
</body>
</html>
