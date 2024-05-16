<?php

    /**
     * Controller parent
     */
    class Ctrl{

        // Tableau des données à utiliser dans la vue
        protected array $_arrData = array();
        /**
         * Methode d'affichage globale
         * @param string $strTemplate Nom de la vue
         * @return void
         */
        protected function display(string $strTemplate){
            // Conversion des données du tableau en variables
            foreach ($this->_arrData as $key=>$value){
                $$key = $value;
            }

            include("views/_partial/header.php");
            include("views/".$strTemplate.".php");
            include("views/_partial/footer.php");
        }
    }