<!-- admin.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/Style/style.css">
    <link rel="stylesheet" href="Assets/Style/Bootstrap/bootstrap.css"/>
    <title>Administration</title>
</head>
<body class="fond">
    <header id="entete">
        <h1 id="title">Administration</h1>
        <!-- Mettez ici vos boutons ou liens pour la déconnexion ou autre -->
    </header>
    <main class="fond">
        <div class="container">
            <h2>Liste des Utilisateurs</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user['nom'] ?></td>
                            <td><?= $user['prenom'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <button onclick="updateRole(<?= $user['id'] ?>)">Modifier Rôle</button>
                                <button onclick="banUser(<?= $user['id'] ?>)">Bannir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
    </footer>
    <!-- Mettez ici vos scripts -->
</body>
</html>
