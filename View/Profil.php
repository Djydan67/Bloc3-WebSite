<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <title>Profil Utilisateur</title>
    <style>
        body {
            background-color: #f2f6c3;
        }

        .container {
            margin-top: 50px;
        }

        .profil-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profil-container h2 {
            color: #68c4af;
        }

        .profil-container ul {
            list-style-type: none;
            padding: 0;
        }

        .profil-container ul li {
            padding: 8px 0;
            
            margin-bottom: 5px;
            border-radius: 4px;
            padding-left: 10px;
            color : #4f7f74;
        }

        .moderation-panel {
            margin-top: 30px;
        }

        .moderation-panel h2 {
            color: #42a5f5;
        }

        .success-message {
            color: #66bb6a;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-custom {
            background-color: #68c4af;
            color: #ffffff;
        }

        .btn-custom:hover {
            background-color: #5aa39c;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <div class="profil-container">
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
                <div class="profil-container moderation-panel">
                    <h2>Panel Modération</h2>
                    <form id="moderationForm" action="index.php?ctrl=user&action=PanneauModeration" method="post">
                        <input type="hidden" name="action" value="PanneauModeration">
                        <div class="form-group">
                            <label for="userSelect">Sélectionnez un utilisateur :</label>
                            <select id="userSelect" name="userId" class="form-control">
                                <?php foreach ($userList as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                        <?php echo htmlspecialchars($user['user_pseudo']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="action" value="ban" class="btn btn-custom">Bannir</button>
                        <button type="submit" name="action" value="addModerator" class="btn btn-custom">Ajouter modérateur</button>
                    </form>
                    
                    <?php if (!empty($messageModo)): ?>
                        <div class="success-message">
                            <?php echo $messageModo; ?>
                        </div>
                    <?php endif; ?>
                </div>  
            <?php endif; ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
