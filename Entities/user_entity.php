<?php
/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
    include("../entities/mother_entity.php");

    class User extends Entity{
		private string $_name;
        private string $_firstname;
		private string $_mail;
        private string $_pwd;
        private int $_isactif;
        private int $_droit;
        private string $_date_de_naissance; 
        private string $_date_de_creation;  
         private string $_pseudonyme;        

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

        /**
         * @param string $dateDeNaissance Date de naissance de l'utilisateur
         * @return void
         */
        public function setDateDeNaissance($dateDeNaissance){
            $this->_date_de_naissance = trim($dateDeNaissance);
        }

        /**
         * @return string Date de naissance
         */
        public function getDateDeNaissance(){
            return $this->_date_de_naissance;
        }

        /**
         * @param string $dateDeCreation Date de création de l'utilisateur
         * @return void
         */
        public function setDateDeCreation($dateDeCreation){
            $this->_date_de_creation = trim($dateDeCreation);
        }

        /**
         * @return string Date de création
         */
        public function getDateDeCreation(){
            return $this->_date_de_creation;
        }

        /**
         * @param string $pseudonyme Pseudonyme de l'utilisateur
         * @return void
         */
        public function setPseudonyme($pseudonyme){
            $this->_pseudonyme = trim($pseudonyme);
        }

        /**
         * @return string Pseudonyme
         */
        public function getPseudonyme(){
            return $this->_pseudonyme;
        }
	}