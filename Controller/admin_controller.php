<?php
// Dans votre contrôleur User_Ctrl
public function admin() {
    // Assurez-vous que l'utilisateur est connecté et a les droits d'administration

    // Chargez les utilisateurs depuis la base de données
    include("models/user_model.php");
    $objUserModel = new user_model();
    $users = $objUserModel->getAllUsers(); // Supposons que vous avez une méthode getAllUsers() dans votre modèle pour récupérer tous les utilisateurs

    // Passer les données à la vue
    $this->_arrData['users'] = $users;

    // Affichez la vue
    $this->_arrData['strPage'] = "admin";
    $this->_arrData['strTitleH1'] = "Administration";
    $this->_arrData['strFirstP'] = "Page d'administration";

    $this->display('admin');


    // Dans votre contrôleur User_Ctrl
public function updateUserRole() {
    // Assurez-vous que l'utilisateur a les droits appropriés pour cette action
   /* if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        // Redirection ou gestion d'erreur appropriée
        return;
    }

    // Vérifiez les paramètres reçus
    if (!isset($_POST['email']) || !isset($_POST['newRole'])) {
        // Gestion d'erreur, paramètres manquants
        return;
    }
    */
    // Récupérez les données du formulaire
    $email = $_POST['email'];
    $newRole = $_POST['newRole'];

    // Mettez à jour le rôle de l'utilisateur dans la base de données
    include("models/user_model.php");
    $objUserModel = new user_model();
    $success = $objUserModel->updateUserRole($email, $newRole);

    // Gestion du succès ou de l'échec de la mise à jour
    if ($success) {
        // Redirection ou message de succès
    } else {
        // Gestion d'erreur, échec de la mise à jour
    }
}

public function banUser() {
    // Assurez-vous que l'utilisateur a les droits appropriés pour cette action
   /* if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        // Redirection ou gestion d'erreur appropriée
        return;
    }

    // Vérifiez les paramètres reçus
    if (!isset($_POST['email'])) {
        // Gestion d'erreur, paramètres manquants
        return;
    }
    */
    // Récupérez les données du formulaire
    $email = $_POST['email'];

    // Bannir l'utilisateur dans la base de données
    include("models/user_model.php");
    $objUserModel = new user_model();
    $success = $objUserModel->banUser($email);

    // Gestion du succès ou de l'échec du bannissement
    if ($success) {
        // Redirection ou message de succès
    } else {
        // Gestion d'erreur, échec du bannissement
    }
}

}
