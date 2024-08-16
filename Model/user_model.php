<?php


	/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
	include("bdd.php");
	
	class user_model extends Bdd{
		public function insert($objUser){
            try {
            $strQuery = "	INSERT INTO T_user (user_mdp, user_nom, user_prenom, user_mail, user_isactif, droit_id, user_pseudo, user_datecreation, user_datenaissance) 
                                VALUES (:mdp, :nom, :prenom, :mail, :isactif, :droit, :pseudonyme, NOW() ,:datenaissance );";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":nom", $objUser->getNom(), PDO::PARAM_STR);
            $strPrepare->bindValue(":prenom", $objUser->getPrenom(), PDO::PARAM_STR);
            $strPrepare->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
            $strPrepare->bindValue(":mdp", $objUser->getHashedPwd(), PDO::PARAM_STR);
            $strPrepare->bindValue(":isactif", $objUser->getIsActif(), PDO::PARAM_INT);
            $strPrepare->bindValue(":droit", $objUser->getDroit(), PDO::PARAM_INT);
            $strPrepare->bindValue(":pseudonyme", $objUser->getPseudonyme(), PDO::PARAM_STR);
            $strPrepare->bindValue(":datenaissance", $objUser->getDatenaissance(), PDO::PARAM_STR);
            return $this->execute_requete($strPrepare);
		} catch (PDOException $e){
            error_log("Insert Error: " . $e->getMessage());
            return false;
        }
        }


        /**
         * Methode de vérification de la présence d'une adresse mail
         * @param string $strMail Adresse mail à tester
         * @return bool vérification ok ou pas
         */
        public function verifMail(string $strMail):bool {
            // Faire la requête
            try {
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
        } catch (PDOException $e) {
            error_log("Verification Mail Error: " . $e->getMessage());
            return false;
        }

        }


        public function getByMail(string $strMail) {
        try {
            $strQuery = "SELECT user_id, user_mail, user_mdp, user_nom, user_prenom, user_isactif, user_pseudo, u.droit_id, droit_description
                         FROM T_user u 
                         INNER JOIN T_droit d ON d.droit_id = u.droit_id
                         WHERE user_mail = :mail";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":mail", $strMail, PDO::PARAM_STR);
            $strPrepare->execute();
            return $strPrepare->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get By Mail Error: " . $e->getMessage());
            return false;
        }
        }


        public function getAllUsers(){
            try {
            $strQuery		= "	SELECT user_mail
                                FROM T_user
                                WHERE droit_id not like '3'";
            $strPrepare     = $this->_db->prepare($strQuery);
            $strPrepare->fetchAll(PDO::FETCH_ASSOC);
            $strPrepare->execute();
            } catch (PDOException $e) {
                error_log("Get All Users Error: " . $e->getMessage());
                return false;
            }
        }

	
    public function updateUserRole($email, $newRole) {
        try {
        $query = $this->_db->prepare("UPDATE T_user SET droit_id = :newRole WHERE email = :email");
        $query->bindParam(':newRole', $newRole);
        $query->bindParam(':email', $email);
        return $query->execute();
        } catch (PDOException $e) {
            error_log("Update User Role Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function banUser($email) {
        try {
        $query = $this->_db->prepare("UPDATE T_user SET user_isactif = 0 WHERE email = :email");
        $query->bindParam(':email', $email);
        return $query->execute();
        } catch (PDOException $e) {
            error_log("Ban User Error: " . $e->getMessage());
            return false;
        }
    }

    public function getById(int $userId){
        try {
        $strQuery = "SELECT user_id, user_mdp, user_nom, user_prenom, user_mail, user_dob, user_creation_date, user_isactif, droit_id 
                     FROM T_user 
                     WHERE user_id = :user_id";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $strPrepare->execute();

        return $strPrepare->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get By Id Error: " . $e->getMessage());
            return false;
        }
    }
  
    
        public function getFirstUser(){
            try {
            $strQuery = "SELECT user_id, user_mdp, user_nom, user_prenom, user_mail, user_isactif, droit_id, user_datenaissance, user_datecreation, user_pseudo  
                         FROM T_user 
                         ORDER BY user_id ASC 
                         LIMIT 1";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->execute();
    
            return $strPrepare->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Get First User Error: " . $e->getMessage());
                return false;
            }
        }


        public function getUsersByDroit($droit) {
            try {
            $strQuery = "SELECT * FROM T_user WHERE droit_id = ?";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->execute([$droit]);
            return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Get Users By Droit Error: " . $e->getMessage());
                return false;
            }
        }
    }
    