<?php
    /**
     * Forum Entity
     * @author Salar
     */

    include("Entities/mother_entity.php");

    class Forum extends Entity{
        private int $_theme;
        private string $_title;
        private string $_message;
        private string $_createdate;
        private int $_author;
        private int $_isvalide;
        private int $_isclose;

        public function __construct(){
            $this->_prefixe = "forum_";
        }

        // Getters & Setters

            /**
             * Setter
             * @param $intTheme = Forum theme
             * @return void
             */
            public function setTheme($intTheme){
                $this->_theme = $intTheme;
            }
            /**
             * Getter
             * @return int Theme
             */
            public function getTheme(){
                return $this->_theme;
            }

            /**
             * Setter
             * @param $strTitle = Forum title 
             * @return void
             */
            public function setTitle($strTitle){
                $this->_title = $strTitle;
            }

            /**
             * Getter
             * @return string Title
             */
            public function getTitle(){
                return $this->_title;
            }

            /**
             * Setter
             * @param $strMessage = Forum message
             * @return void
             */
             public function setMessage($strMessage){
                $this->_message = $strMessage;
            }
            /**
             * Getter
             * @return string Message
             */
            public function getMessage(){
                return $this->_message;
            }

            /**
             * Setter
             * @param $strDate = Forum date  
             * @return void
             */
            public function setDate($strDate){
                $this->_createdate = $strDate;
            }

            /**
             * Getter
             * @return string Date
             */
            public function getDate(){
                return $this->_createdate;
            }

            /**
             * Setter
             * @param $intUser = Forum author
             * @return void
             */
            public function setAuthor($intTheme){
                $this->_author = $intTheme;
            }
            /**
             * Getter
             * @return int Author
             */
            public function getAuthor(){
                return $this->_author;
            }

            /**
             * Setter
             * @param $intIsvalide = Forum is valide or not
             * @return void
             */
            public function setIsvalide($intIsvalide){
                $this->_isvalide = $intIsvalide;
            }
            /**
             * Getter
             * @return int is Valide or not
             */
            public function getIsvalide(){
                return $this->_isvalide;
            }

            /**
             * Setter
             * @param $intIsclose = Forum is closed or not
             * @return void
             */
            public function setIsclose($intIsclose){
                $this->_isclose = $intIsclose;
            }
            /**
             * Getter
             * @return int is closed or not
             */
            public function getIsclose(){
                return $this->_isclose;
            }
    }