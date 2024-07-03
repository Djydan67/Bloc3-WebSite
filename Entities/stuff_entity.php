<?php 

/**
 *  Entité des équipements
 * @author Renaud Siegel
 */
    include("entities/mother_entity.php");

    class Stuff extends Entity{
        //Attributs
        private string $_name;
        private string $_imgPath;
        private string $_level;
        private string $_setType;
        private string $_description;
        private string $_pieces;

        public function __construct(){
            $this->_prefixe = "article_";
        }

        //Getters et Setters

        /**
         * Setter du nom
         * @param $strName Nom de l'item
         * @return void
         */
        public function setName($strName){
            $this->_name = $strName;
        }

        /**
         * Getter du nom
         * @return string Nom
         */
        public function getName(){
            return $this->_name;
        }
        /**
         * Setter de l'image
         * @param $strImg chemin de l'image
         * @return void
         */
        public function setImg($strImg){
            $this->_imgPath = $strImg;
        }

        /**
         * Getter de l'immage
         * @return string Image
         */
        public function getImg(){
            return $this->_imgPath;
        }
        /**
         * Setter du level
         * @param $intLevel Level de l'item
         * @return void
         */
        public function setLevel($intName){
            $this->_level = $intName;
        }

        /**
         * Getter du level
         * @return int Level
         */
        public function getLevel(){
            return $this->_level;
        }
        /**
         * Setter du type
         * @param $intType Type de l'item
         * @return void
         */
        public function setType($intType){
            $this->_setType = $intType;
        }

        /**
         * Getter du type
         * @return int Type
         */
        public function getType(){
            return $this->_setType;
        }
        /**
         * Setter de la description
         * @param $strDescription Description de l'item
         * @return void
         */
        public function setDescription($strDescription){
            $this->_description = $strDescription;
        }

        /**
         * Getter de la description
         * @return string Description
         */
        public function getDescription(){
            return $this->_description;
        }

        /**
         * Setter de la piece
         * @param $strPiece Piece de l'item
         * @return void
         */
        public function setPieces($strPiece){
            $this->_pieces = $strPiece;
        }

        /**
         * Getter de la piece
         * @return string Piece
         */
        public function getPieces(){
            return $this->_pieces;
        }

    }