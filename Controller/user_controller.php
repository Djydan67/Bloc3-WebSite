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
        require_once("Model/user_model.php");
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
                        header("Location:index.php");
                    } else {
                            $arrErrors[] = "le mail ou le mot de passe est incorrect";
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
        
        $this->display('login');
    }

     /**
     * login Mobile
     * @return void
     */
    public function loginMobile()
    {
        require_once("Model/user_model.php");
        require_once("jwt_controller.php");
    
        $objUserModel = new user_model();
        $objJwt = new Jwt();
        $arrErrors = array();
    
        if (count($_POST) > 0) {
            // Récupérer le mail et le mot de passe
            $strMail = trim($_POST['mail']);
            $strPassword = $_POST['mdp'];
    
            if ($strMail == "" || $strPassword == "") {
                $arrErrors[] = "Le mail et le mot de passe sont obligatoires";
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
    
                        // Générer le token JWT
                        $jwtToken = $objJwt->SessionJwt($arrUser);
    
                        if ($jwtToken !== false) {
                            $response = [
                                "status" => "success",
                                "message" => "Vous êtes bien connecté",
                                "token" => $jwtToken
                            ];
                            echo json_encode($response);
                            return;
                        } else {
                            $arrErrors[] = "Erreur lors de la génération du token";
                        }
                    } else {
                        $arrErrors[] = "Le mail ou le mot de passe est incorrect";
                    }
                }
            }
        }
    
        if (count($arrErrors) > 0) {
            $response = [
                "status" => "error",
                "message" => $arrErrors
            ];
            echo json_encode($response);
        } else {
            // Handle the case where no errors are present but no response is sent
            $response = [
                "status" => "error",
                "message" => "Une erreur inconnue s'est produite."
            ];
            echo json_encode($response);
        }
    }

    /**
     * Page de création de compte
     * @return void
     */
    public function create_account()
    {
        include("Model/user_model.php");
        $objUserModel   = new user_model();
        $arrErrors      = array();

        if (count($_POST) > 0) {
            include("Entities/user_entity.php");
            $objUser = new User();
            $objUser->hydrate($_POST);
            $this->_arrData['objUser'] = $objUser;

            if ($objUser->getNom() == "") {
                $arrErrors['nom'] = "Le nom est obligatoire";
            }
            if ($objUser->getPrenom() == "") {
                $arrErrors['prenom'] = "Le prénom est obligatoire";
            }
            if ($objUser->getMail() == "") {
                $arrErrors['mail'] = "Le mail est obligatoire";
            } elseif (!filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL)) {
            } elseif ($objUserModel->verifMail($objUser->getMail()) !== false) {
                $arrErrors['mail'] = "Le mail existe déjà";
            }
            if ($objUser->getPseudonyme() == "") {
                $arrErrors['pseudonyme'] = "Le pseudonyme est obligatoire";
            }

            $regex = '#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{16,20}$#';
            if ($objUser->getMdp() == "") {
                $arrErrors['mdp'] = "Le mot de passe est obligatoire";
            } elseif (!preg_match($regex, $objUser->getMdp())) {
                $arrErrors['mdp'] = "Le mot de passe n'est pas correct";
            } elseif ($objUser->getMdp() != $_POST['confirmpwd']) {
                $arrErrors['mdp'] = "Le mot de passe et sa confirmation sont incorrect";
            }

            if (count($arrErrors) == 0) {
                $boolInsert = $objUserModel->insert($objUser);
                if ($boolInsert) {
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

        $this->display('create_account');
    }

    /**
     * Page de déconnection
     * @return void
     */
    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['valid'] = "Vous êtes bien déconnecté";

        header("Location:index.php");
    }

    /**
     * Page de profil du premier utilisateur trouvé
     * @return void
     */
    public function profileFirstUser()
    {
        include("models/user_model.php");
        $objUserModel = new user_model();

        $arrUser = $objUserModel->getFirstUser();

        if ($arrUser === false) {
            echo "Erreur : aucun utilisateur trouvé.";
            exit();
        }

        $userLevel = $arrUser['droit_id'];

        $this->_arrData['arrUser']      = $arrUser;
        $this->_arrData['userLevel']    = $userLevel;

        $this->_arrData['strPage']      = "profile";
        $this->_arrData['strTitleH1']   = "Profil Utilisateur";
        $this->_arrData['strFirstP']    = "Page de profil du premier utilisateur";

        $this->display('profile');
    }
}
