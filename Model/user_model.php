<?php
	/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
	include("bdd.php");
	
	class user_model extends Bdd{
		
		public function insert($objUser){

            $strQuery = "	INSERT INTO T_user (user_mdp, user_nom, user_prenom, user_mail, user_isactif, droit_id ) 
                                VALUES (:mdp, :nom, :prenom, :mail, :isactif, :droit);";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":nom", $objUser->getName(), PDO::PARAM_STR);
            $strPrepare->bindValue(":prenom", $objUser->getFirstname(), PDO::PARAM_STR);
            $strPrepare->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
            $strPrepare->bindValue(":mdp", $objUser->getHashedPwd(), PDO::PARAM_STR);
            $strPrepare->bindValue(":isactif", $objUser->getIsActif(), PDO::PARAM_INT);
            $strPrepare->bindValue(":droit", $objUser->getDroit(), PDO::PARAM_INT);
            return $this->execute_requete($strPrepare);
		}

        /**
         * Methode de vérification de la présence d'une adresse mail
         * @param string $strMail Adresse mail à tester
         * @return bool vérification ok ou pas
         */
        public function verifMail(string $strMail):bool {
            // Faire la requête
            $strQuery = "	SELECT user_nom
	                            FROM T_user
                                WHERE user_mail = :mail;";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":mail", $strMail, PDO::PARAM_STR);
            //$strPrepare->execute();
            $strPrepare = $this->execute_requete($strPrepare);
            if ($strPrepare !== false) {
                return is_array($strPrepare->fetch());
            }
            return false;
        }

        public function getByMail(string $strMail):array|bool{
            // Faire la requête
            $strQuery		= "	SELECT user_mdp, user_nom, user_prenom, user_isactif, droit_id 
	                            FROM T_user
                                WHERE user_mail = :mail;";
            $strPrepare     = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":mail", $strMail, PDO::PARAM_STR);
            $strPrepare->execute();

            return $strPrepare->fetch();
        }

        public function getAllUsers(){
            $strQuery		= "	SELECT user_mail
                                FROM T_user
                                WHERE droit_id not like '3'";
            $strPrepare     = $this->_db->prepare($strQuery);
            $query->fetchAll(PDO::FETCH_ASSOC);
            $strPrepare->execute();


        }

	
    public function updateUserRole($email, $newRole) {
        $query = $this->_db->prepare("UPDATE T_user SET droit_id = :newRole WHERE email = :email");
        $query->bindParam(':newRole', $newRole);
        $query->bindParam(':email', $email);
        return $query->execute();
    }
    
    public function banUser($userId) {
        $query = $this->_db->prepare("UPDATE T_user SET user_isactif = 0 WHERE user_id = :userId");
        $query->bindParam(':userId', $userId);
        return $query->execute();
    }

    public function createModerateur($userId) {
        $query = $this->_db->prepare("UPDATE T_user SET droit_id = 2 WHERE user_id = :userId");
        $query->bindParam(':userId', $userId);
        return $query->execute();
    }

    public function getById(int $userId): array|bool {
        $strQuery = "SELECT user_id, user_mdp, user_nom, user_prenom, user_mail, user_dob, user_creation_date, user_isactif, droit_id 
                     FROM T_user 
                     WHERE user_id = :user_id";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $strPrepare->execute();

        return $strPrepare->fetch(PDO::FETCH_ASSOC);
    }
  
    
        public function getFirstUser(): array|bool {
            $strQuery = "SELECT user_id, user_mdp, user_nom, user_prenom, user_mail, user_isactif, droit_id, user_datenaissance, user_datecreation, user_pseudo  
                         FROM T_user 
                         ORDER BY user_id ASC 
                         LIMIT 1";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->execute();
    
            return $strPrepare->fetch(PDO::FETCH_ASSOC);
        }
        public function getUsersByDroit($droit) {
            
            $strQuery = "SELECT * FROM T_user WHERE droit_id = ?";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->execute([$droit]);
            return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // ... autres méthodes ...
    }
    