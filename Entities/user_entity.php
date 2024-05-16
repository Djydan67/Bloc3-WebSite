<?php
/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
    include("entities/mother_entity.php");

    class User extends Entity{
		private string $_name;
        private string $_firstname;
		private string $_mail;
        private string $_pwd;
        private int $_isactif;
        private int $_droit;

        public function __construct(){
            $this->_prefixe = "user_";
        }

        /**
         * @param $strName Nom de l'utilisateur
         * @return void
         */
		public function setName($strName){
			$this->_name = strtoupper(trim($strName));
		}

        /**
         * @return string Nom
         */
		public function getName(){
			return $this->_name;
		}

        /**
         * @param $strFirstname Prénom de l'utilisateur
         * @return void
         */
        public function setFirstname($strFirstname){
            $this->_firstname = trim($strFirstname);
        }

        /**
         * @return string Prénom
         */
        public function getFirstname(){
            return $this->_firstname;
        }

        /**
         * @param $strMail Mail de l'utilisateur
         * @return void
         */
        public function setMail($strMail){
            $this->_mail = strtolower(trim($strMail));
        }

        /**
         * @return string Mail
         */
        public function getMail(){
            return $this->_mail;
        }

        /**
         * @param $strPwd Mot de passe de l'utilisateur
         * @return void
         */
        public function setPwd($strPwd){
            $this->_pwd = $strPwd;
        }

        /**
         * @return string Mot de passe
         */
        public function getPwd(){
            return $this->_pwd;
        }

        public function getHashedPwd(){
            return password_hash($this->_pwd, PASSWORD_DEFAULT);
        }

        public function setIsActif($intActif) {
            $this->_isactif = is_int($intActif);
        }

        public function getIsActif() {
            return $this->_isactif;
        }

        public function setDroit($intDroit) {
            $this->_droit = is_int($intDroit);
        }

         public function getDroit() {
            return $this->_droit;
         }
	}