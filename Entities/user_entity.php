<?php
/**
 * Entité des utilisateurs
 * @author Théo Bance
 *
 */
    include("mother_entity.php");

    class User extends Entity{
		private string $_nom;
        private string $_prenom;
		private string $_mail;
        private string $_mdp;
        private int $_isactif = 1;
        private int $_droit = 1;
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
		public function setNom($strName){
			$this->_nom = strtoupper(trim($strName));
		}

        /**
         * @return string Nom
         */
		public function getNom(){
			return $this->_nom;
		}

        /**
         * @param $strFirstname Prénom de l'utilisateur
         * @return void
         */
        public function setPrenom($strFirstname){
            $this->_prenom = trim($strFirstname);
        }

        /**
         * @return string Prénom
         */
        public function getPrenom(){
            return $this->_prenom;
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
        public function setMdp($strPwd){
            $this->_mdp = $strPwd;
        }

        /**
         * @return string Mot de passe
         */
        public function getMdp(){
            return $this->_mdp;
        }

        public function getHashedPwd(){
            return password_hash($this->_mdp, PASSWORD_DEFAULT);
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