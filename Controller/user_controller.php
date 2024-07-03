<?php
/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
    class User_Ctrl extends Ctrl
    {
        /**
         * Page de login
         * @return void
         */
        public function login()
        {
            include("Model/user_model.php");
            $objUserModel = new user_model();
            $arrErrors = array();

            if (count($_POST) > 0) {
                // Récupérer le mail et le mot de passe
                $strMail = trim($_POST['mail']);
                $strPassword = $_POST['mdp'];

                if ($strMail == "" || $strPassword == "") {
                    $arrErrors[] = "Le mail et le mot de passe sont obligatoire";
                }
                if (count($arrErrors) == 0) {
                    // Rechercher l'utilisateur en fonction du mail
                    $arrUser = $objUserModel->getByMail($strMail);
                    if ($arrUser === false) {
                        $arrErrors[] = "Erreur de connexion";
                    } else {
                        // Comparer le mot de passe
                        if (password_verify($strPassword, $arrUser['user_mdp'])) {
                            unset($arrUser['user_mdp']);
                            $_SESSION['user'] = $arrUser;
                            $_SESSION['valid'] = "Vous êtes bien connecté";
                             header("Location:");
                        } else {
                            $arrErrors[] = "Erreur de connexion";
                        }
                    }
                }
            }

            if (count($arrErrors) > 0) {
                echo "<div class='alert alert-danger'>";
                foreach ($arrErrors as $strError) {
                    echo "<p>" . $strError . "</p>";
                }
                echo "</div>";
            }

            $this->_arrData['strPage']      = "login";
            $this->_arrData['strTitleH1']   = "Me connecter";
            $this->_arrData['strFirstP']    = "Page de connexion";

            $this->prepare('login');
        }

        /**
         * Page de création de compte
         * @return void
         */
        public function create_account() {
            include("Model/user_model.php");
            $objUserModel   = new user_model();
            $arrErrors      = array();

            if (count($_POST) > 0) {
                include("Entities/user_entity.php");
                $objUser = new User();
                $objUser->hydrate($_POST);
                $this->_arrData['objUser']      = $objUser;

                if ($objUser->getName() == "") {
                    $arrErrors['nom'] = "Le nom est obligatoire";
                }
                if ($objUser->getFirstname() == "") {
                    $arrErrors['prenom'] = "Le prénom est obligatoire";
                }
                if ($objUser->getMail() == "") {
                    $arrErrors['mail'] = "Le mail est obligatoire";
                }elseif (!filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL)){
                    $arrErrors['mail'] = "Le mail n'est pas correct";
                }elseif ($objUserModel->verifMail($objUser->getMail()) !== false){
                    $arrErrors['mail'] = "Le mail existe déjà";
                }

                // Expression régulière REGEX
                $regex = '#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{16,20}$#';
                if ($objUser->getPwd() == "") {
                    $arrErrors['mdp'] = "Le mot de passe est obligatoire";
                }elseif (!preg_match($regex, $objUser->getPwd() )){
                    $arrErrors['mdp'] = "Le mot de passe n'est pas correct";
                }elseif ($objUser->getPwd() != $_POST['confirmpwd']) {
                    $arrErrors['mdp'] = "Le mot de passe et sa confirmation sont incorrect";
                }

                // Si tout est ok => Insertion BDD
                if (count($arrErrors) == 0) {
                    $boolInsert = $objUserModel->insert($objUser);
                    if ($boolInsert){
                        $_SESSION['valid']  = "Le compte a bien été créé, vous pouvez vous connecter.";
                        header("Location:index.php?ctrl=user&action=login");
                    }

                }
            }

            if (count($arrErrors) > 0) {
                echo "<div class='alert alert-danger'>";
                foreach ($arrErrors as $strError) {
                    echo "<p>" . $strError . "</p>";
                }
                echo "</div>";
            }

            $this->_arrData['strPage']      = "create_account";
            $this->_arrData['strTitleH1']   = "Créer un compte";
            $this->_arrData['strFirstP']    = "Page de création de compte";

            $this->prepare('create_account');
        }

        /**
         * Page de déconnection
         * @return void
         */
        public function logout() {
            session_destroy();

            // on recréé la session pour le message
            session_start();
            $_SESSION['valid'] = "Vous êtes bien déconnecté";

        // on redirige
        header("Location:index.php");
    }


    public function profil()
    {            
        include("Model/user_model.php");
        $UserModel = new user_model();
        $arrUser = $UserModel->getFirstUser();
      
        $arrUser = $UserModel->getFirstUser();
        $userLevel = $arrUser['user_droit'] ?? 1; 
        var_dump($arrUser);

        // Retrieve list of users with droit = 1
        $userList = $UserModel->getUsersByDroit(1);
      
        if ($arrUser === false) {
            echo "Erreur : aucun utilisateur trouvé.";
            exit();
        }

        // Déterminer le niveau de droit de l'utilisateur
        $userLevel = $arrUser['droit_id'];

   

        $this->_arrData['arrUser']      = $arrUser;
        $this->_arrData['userLevel']    = $userLevel;
        $this->_arrData['userList'] = $userList;
   
      

    
      
        $this->_arrData['strPage'] = "profil";
        $this->_arrData['strTitleH1'] = "profil utilisateur";
        $this->_arrData['strFirstP'] = "";
        $this->display('profil');
    }
    /**
     * Page de profil du premier utilisateur trouvé
     * @return void
     */
    public function profileFirstUser() {
        // Récupérer le premier utilisateur
        $arrUser = $UserModel->getFirstUser();
        include("Model/user_model.php");
        $UserModel = new user_model();
        $arrUser = $UserModel->getFirstUser();
        $userLevel = $arrUser['user_droit'] ?? 1; 
        var_dump($arrUser);

        // Retrieve list of users with droit = 1
        $userList = $UserModel->getUsersByDroit(1);

        if ($arrUser === false) {
            echo "Erreur : aucun utilisateur trouvé.";
            exit();
        }

        // Déterminer le niveau de droit de l'utilisateur
        $userLevel = $arrUser['droit_id'];

        var_dump($arrUser); // Debug
        var_dump($userLevel); // Debug

        $this->_arrData['arrUser']      = $arrUser;
        $this->_arrData['userLevel']    = $userLevel;

        $this->_arrData['strPage']      = "profile";
        $this->_arrData['strTitleH1']   = "Profil Utilisateur";
        $this->_arrData['strFirstP']    = "Page de profil du premier utilisateur";

        $this->prepare('profile');
    }

    public function PanneauModeration() {
        $message = "";
        include("Model/user_model.php");
        $objUserModel = new user_model();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? '';
            $userId = $_POST['userId'] ?? '';
            
            if ($action && $userId) {
                switch ($action) {
                    case 'ban':
                       
                     $objUserModel->banUser($userId);
                            
                        
                        break;
                    case 'addModerator':
                        $objUserModel->createModerateur($userId);
                        
                        break;
                    default:
                        $message = "Action non reconnue.";
                        break;
                }
            } 
        }
        header("Location:index.php?ctrl=user&action=profil");
    }

}