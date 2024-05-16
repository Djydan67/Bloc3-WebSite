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

	}