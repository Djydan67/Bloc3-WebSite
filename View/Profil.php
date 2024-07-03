<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <title>Profil Utilisateur</title>
</head>

<body class="fond">
    <header id="entete">
        <h1 id="title">Profil Utilisateur</h1>
    </header>
    <main class="fond">
        <div class="container">
            <?php
            include("Entities/user_entity.php");
            include("Model/user_model.php");
            $UserModel = new user_model();
            $arrUser = $UserModel->getFirstUser();
            $userLevel = $arrUser['user_droit'] ?? 1; 
            var_dump($arrUser);

            // Retrieve list of users with droit = 1
            $userList = $UserModel->getUsersByDroit(1);
            ?>
            <div id="ProfilText" class="profil-texte-blanc">
                <h2>Informations du Profil</h2>
                <ul>
                    <li>Pseudo: <?php echo htmlspecialchars($arrUser['user_pseudo'] ?? 'N/A'); ?></li>
                    <li>Nom: <?php echo htmlspecialchars($arrUser['user_nom'] ?? 'N/A'); ?></li>
                    <li>Prénom: <?php echo htmlspecialchars($arrUser['user_prenom'] ?? 'N/A'); ?></li>
                    <li>Email: <?php echo htmlspecialchars($arrUser['user_mail'] ?? 'N/A'); ?></li>
                    <li>Date de Naissance: <?php echo htmlspecialchars($arrUser['user_datenaissance'] ?? 'N/A'); ?></li>
                    <li>Date de Création du Compte: <?php echo htmlspecialchars($arrUser['user_datecreation'] ?? 'N/A'); ?></li>
                </ul>
            </div>

            <?php if ($arrUser['droit_id'] == 2 || $arrUser['droit_id'] == 3) : ?>
                <div id="ProfilText" class="profil-texte-blanc">
                    <h2>Panel Modération</h2>
                    <form id="moderationForm" action="index.php?ctrl=user&action=PanneauModeration" method="post">
                        <input type="hidden" name="action" value="PanneauModeration">
                        <div>
                            <label for="userSelect">Sélectionnez un utilisateur :</label>
                            <select id="userSelect" name="userId">
                                <?php foreach ($userList as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                        <?php echo htmlspecialchars($user['user_pseudo']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="banReason">Raison du ban :</label>
                            <textarea id="banReason" name="banReason" placeholder="Raison du ban"></textarea>
                        </div>
                        <button type="submit" name="action" value="ban">Bannir</button>
                        <button type="submit" name="action" value="addModerator">Ajouter modérateur</button>
                    </form>
                </div>
            <?php endif; ?>
    </main>
    <?php 
    include("_partial/footer.php");
    ?>
</body>
</html>
